<?php

namespace App\Services;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class InquiryProtection
{
    public function verifyVisitor(Request $request): void
    {
        if (! config('inquiries.turnstile.enabled')) {
            return;
        }

        $token = $request->validate([
            'cf-turnstile-response' => ['required', 'string', 'max:2048'],
        ], ['cf-turnstile-response.required' => 'Please complete the verification before sending.'])['cf-turnstile-response'];

        if (! config('inquiries.turnstile.site_key') || ! config('inquiries.turnstile.secret_key')) {
            $this->verificationFailed();
        }

        try {
            $response = Http::asForm()->connectTimeout(3)->timeout(8)->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                ['secret' => config('inquiries.turnstile.secret_key'), 'response' => $token, 'remoteip' => $request->ip()],
            );
        } catch (\Throwable $exception) {
            Log::warning('Roxel inquiry verification unavailable', ['exception' => $exception::class]);
            $this->verificationFailed();
        }

        if (! $response->successful() || $response->json('success') !== true
            || ! in_array($response->json('hostname'), config('inquiries.turnstile.hostnames'), true)
            || $response->json('action') !== config('inquiries.turnstile.action')) {
            $this->verificationFailed();
        }

        if (! Cache::add('roxel:inquiries:token:'.$this->fingerprint($token), true, 300)) {
            $this->verificationFailed();
        }
    }

    /** @param array<string, string|null> $data */
    public function reserve(array $data): string
    {
        $key = 'roxel:inquiries:duplicate:'.$this->fingerprint(json_encode([
            strtolower(trim($data['email'])),
            $data['interest'],
            preg_replace('/\s+/u', ' ', trim($data['message'])),
        ], JSON_THROW_ON_ERROR));

        try {
            return Cache::lock('roxel:inquiries:reservation', 10)->block(3, function () use ($key): string {
                if (Cache::has($key)) {
                    throw ValidationException::withMessages(['message' => 'This inquiry has already been submitted. Please wait before sending it again.']);
                }

                $window = Cache::get('roxel:inquiries:daily', ['count' => 0, 'expires' => now()->timestamp + 86400]);
                $limit = max(1, (int) config('inquiries.daily_limit'));
                if ($window['count'] >= $limit) {
                    throw ValidationException::withMessages(['message' => 'The inquiry service is temporarily at capacity. Please try again later.']);
                }

                Cache::put($key, true, (int) config('inquiries.duplicate_seconds'));
                $window['count']++;
                Cache::put('roxel:inquiries:daily', $window, max(1, $window['expires'] - now()->timestamp));
                if ($window['count'] === $limit) {
                    Log::critical('Roxel inquiry daily ceiling reached', ['limit' => $limit, 'window_expires' => $window['expires']]);
                }

                return $key;
            });
        } catch (LockTimeoutException) {
            throw ValidationException::withMessages(['message' => 'The inquiry service is busy. Please try again shortly.']);
        }
    }

    private function fingerprint(string $value): string
    {
        return hash_hmac('sha256', $value, (string) config('app.key'));
    }

    private function verificationFailed(): never
    {
        throw ValidationException::withMessages(['cf-turnstile-response' => 'Verification could not be completed. Please refresh the verification and try again.']);
    }
}
