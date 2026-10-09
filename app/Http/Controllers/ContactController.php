<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('b_website')) {
            return back()->with('success', 'Thank you. Your inquiry has been received.');
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:150'],
            'interest' => ['required', 'string', Rule::in([
                'Investment Portfolio',
                'Cyprus Permanent Residency',
                'Bespoke Services',
                'General Inquiry',
            ])],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        try {
            Mail::send('emails.contact', ['inquiryData' => $data], function ($message) use ($data) {
                $message->to(config('mail.roxel_inquiries_to', 'info@roxelinvest.com'))
                    ->replyTo($data['email'], trim($data['first_name'].' '.$data['last_name']))
                    ->subject('Roxel Invest | New consultation request');
            });

            return back()->with('success', 'Thank you. Your inquiry has been received.');
        } catch (\Throwable $exception) {
            Log::error('Roxel Invest contact form failed', [
                'exception' => $exception->getMessage(),
                'email' => $data['email'] ?? null,
            ]);

            return back()
                ->withInput()
                ->with('error', 'We could not send your inquiry right now. Please email info@roxelinvest.com directly.');
        }
    }
}
