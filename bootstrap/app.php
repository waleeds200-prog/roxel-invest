<?php

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $exception, Request $request): ?Response {
            if (! $request->isMethod('post') || (! $request->routeIs('contact.store') && ! $request->is('contact'))) {
                return null;
            }

            $headers = $exception->getHeaders();
            $seconds = max(1, (int) ($headers['Retry-After'] ?? 86400));
            $minutes = (int) ceil($seconds / 60);
            $hours = (int) ceil($seconds / 3600);
            $wait = $minutes < 60 ? $minutes.' '.Str::plural('minute', $minutes) : $hours.' '.Str::plural('hour', $hours);
            $message = "You've reached the inquiry limit. Please try again in about {$wait}, or email info@roxelinvest.com.";

            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'retry_after' => $seconds], 429, $headers);
            }

            $input = [];
            foreach (['first_name' => 100, 'last_name' => 100, 'phone' => 40, 'email' => 150, 'interest' => 100, 'message' => 3000] as $field => $length) {
                if (is_string($request->input($field))) {
                    $input[$field] = Str::limit($request->input($field), $length, '');
                }
            }

            return redirect()->to(route('contact').'#inquiry-form')
                ->with('error', $message)
                ->withInput($input)
                ->withHeaders($headers);
        });
    })->create();
