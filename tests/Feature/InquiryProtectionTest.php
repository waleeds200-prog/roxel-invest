<?php

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

function inquiryPayload(string $message = 'Please send information.', string $token = 'valid-token'): array
{
    return ['first_name' => 'Test', 'last_name' => 'Visitor', 'email' => 'visitor@example.com',
        'interest' => 'General Inquiry', 'message' => $message, 'cf-turnstile-response' => $token];
}

function enableInquiryVerification(): void
{
    config(['inquiries.turnstile.enabled' => true, 'inquiries.turnstile.site_key' => 'public-test-key', 'inquiries.turnstile.secret_key' => 'private-test-key']);
    Http::preventStrayRequests();
}

test('valid Turnstile verification permits mail and does not expose its secret', function () {
    enableInquiryVerification();
    Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true, 'hostname' => 'roxelinvest.com', 'action' => 'contact'])]);
    Mail::shouldReceive('send')->once();

    $this->get('/investor-relations')->assertOk()->assertSee('cf-turnstile', false)->assertDontSee('private-test-key');
    $this->post('/investor-relations', inquiryPayload())->assertSessionHas('success');
    Http::assertSent(fn ($request) => $request['secret'] === 'private-test-key' && $request['response'] === 'valid-token');
});

test('missing Turnstile token cannot send mail', function () {
    enableInquiryVerification();
    Mail::fake();
    $this->post('/investor-relations', inquiryPayload(token: ''))->assertSessionHasErrors('cf-turnstile-response');
    Http::assertNothingSent();
    Mail::assertNothingOutgoing();
});

test('invalid or mismatched Turnstile response cannot send mail', function (array $result) {
    enableInquiryVerification();
    Http::fake(['challenges.cloudflare.com/*' => Http::response($result)]);
    Mail::fake();
    $this->post('/investor-relations', inquiryPayload())->assertSessionHasErrors('cf-turnstile-response');
    Mail::assertNothingOutgoing();
})->with([
    [['success' => false, 'error-codes' => ['timeout-or-duplicate']]],
    [['success' => true, 'hostname' => 'other.example', 'action' => 'contact']],
    [['success' => true, 'hostname' => 'roxelinvest.com', 'action' => 'other-form']],
]);

test('Turnstile outage or missing keys blocks sending instead of bypassing verification', function () {
    enableInquiryVerification();
    $calls = 0;
    Http::fake(function () use (&$calls) {
        $calls++;
        throw new ConnectionException('unavailable');
    });
    Mail::fake();
    $this->post('/investor-relations', inquiryPayload())->assertSessionHasErrors('cf-turnstile-response');
    config(['inquiries.turnstile.secret_key' => null]);
    $this->get('/investor-relations')->assertSee('Online inquiries are temporarily unavailable.');
    $this->post('/investor-relations', inquiryPayload())->assertSessionHasErrors('cf-turnstile-response');
    expect($calls)->toBe(1);
    Mail::assertNothingOutgoing();
});

test('a verified token cannot be replayed for another message', function () {
    enableInquiryVerification();
    Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true, 'hostname' => 'roxelinvest.com', 'action' => 'contact'])]);
    Mail::shouldReceive('send')->once();
    $this->post('/investor-relations', inquiryPayload())->assertSessionHas('success');
    $this->post('/contact', inquiryPayload('A different message.'))->assertSessionHasErrors('cf-turnstile-response');
});

test('duplicate inquiries across IP addresses send only once and expire after ten minutes', function () {
    config(['inquiries.turnstile.enabled' => false]);
    Mail::shouldReceive('send')->twice();
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1'])->post('/investor-relations', inquiryPayload())->assertSessionHas('success');
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.2'])->post('/contact', inquiryPayload())->assertSessionHasErrors('message');
    $this->travel(11)->minutes();
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.3'])->post('/investor-relations', inquiryPayload())->assertSessionHas('success');
});

test('IP limit is shared by both endpoints and expires after twenty four hours', function () {
    Mail::fake();
    for ($attempt = 0; $attempt < 3; $attempt++) {
        $this->post('/investor-relations', ['b_website' => 'spam'])->assertRedirect();
    }
    $this->post('/contact', ['b_website' => 'spam'])->assertStatus(429)->assertHeader('Retry-After');
    $this->travel(23)->hours();
    $this->post('/contact', ['b_website' => 'spam'])->assertStatus(429);
    $this->travel(2)->hours();
    $this->post('/contact', ['b_website' => 'spam'])->assertRedirect();
    Mail::assertNothingOutgoing();
});

test('global ceiling blocks different IP addresses alerts once and resets after twenty four hours', function () {
    config(['inquiries.turnstile.enabled' => false, 'inquiries.daily_limit' => 2]);
    Mail::shouldReceive('send')->times(3);
    Log::shouldReceive('critical')->once()->with('Roxel inquiry daily ceiling reached', Mockery::on(fn ($context) => $context['limit'] === 2));
    foreach ([1, 2] as $number) {
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.'.$number])->post('/investor-relations', inquiryPayload('Message '.$number))->assertSessionHas('success');
    }
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.3'])->post('/investor-relations', inquiryPayload('Message 3'))->assertSessionHasErrors('message');
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.4'])->post('/contact', inquiryPayload('Message 4'))->assertSessionHasErrors('message');
    $this->travel(25)->hours();
    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.5'])->post('/investor-relations', inquiryPayload('Message 5'))->assertSessionHas('success');
});

test('failed mail does not prevent retrying the same inquiry', function () {
    config(['inquiries.turnstile.enabled' => false]);
    Mail::shouldReceive('send')->once()->andThrow(new RuntimeException('transport failed'));
    $this->post('/investor-relations', inquiryPayload())->assertSessionHas('error');
    Mail::shouldReceive('send')->once()->andReturn(null);
    $this->post('/investor-relations', inquiryPayload())->assertSessionHas('success');
});
