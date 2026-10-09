<?php

use Illuminate\Support\Facades\Mail;

test('inquiry rejects an interest outside the offered choices without sending mail', function () {
    Mail::fake();

    $this->from('/investor-relations')->post('/investor-relations', [
        'first_name' => 'Test',
        'last_name' => 'Visitor',
        'email' => 'visitor@example.com',
        'interest' => 'Unrecognized interest',
        'message' => 'Please send information.',
    ])->assertSessionHasErrors('interest');

    Mail::assertNothingOutgoing();
});

test('inquiry validation escapes retained user input and identifies the invalid field', function () {
    Mail::fake();

    $this->followingRedirects()->from('/investor-relations')->post('/investor-relations', [
        'first_name' => '<script>alert(1)</script>',
        'last_name' => 'Visitor',
        'email' => 'invalid-email',
        'interest' => 'General Inquiry',
        'message' => 'Please send information.',
    ])->assertOk()
        ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
        ->assertDontSee('<script>alert(1)</script>', false)
        ->assertSee('aria-describedby="email-error"', false);

    Mail::assertNothingOutgoing();
});

test('inquiry honeypot does not send mail and repeated submissions are throttled', function () {
    Mail::fake();

    for ($attempt = 0; $attempt < 6; $attempt++) {
        $this->post('/investor-relations', ['b_website' => 'spam.example'])->assertRedirect();
    }

    $this->post('/investor-relations', ['b_website' => 'spam.example'])->assertStatus(429);
    Mail::assertNothingOutgoing();
});
