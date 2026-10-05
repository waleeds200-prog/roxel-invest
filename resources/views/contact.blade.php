@extends('layouts.app')
@section('title', 'Investor Relations | ROXEL INVEST')
@section('meta_description', 'Discuss tailored Roxel Invest opportunities, off-market assets and the Cyprus Permanent Residency pathway with our advisory team.')
@section('body_class', 'page-investor')

@section('content')
<section class="hero hero--inner hero--investor" style="--hero-image: url('{{ asset('assets/rox2026/images/hero-investor.jpg') }}')">
    <div class="hero__shade"></div>
    <svg class="hero__motif hero__motif--investor-exact" viewBox="0 0 1920 932" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z" />
    </svg>
    <div class="hero__content shell" data-reveal>
        <p class="hero__eyebrow">Get In Touch</p>
        <h1>Investor Relations</h1>
        <p class="hero__intro">Discuss Tailored Investment Opportunities, Off-Market Assets, And The Cyprus Permanent Residency Pathway With Our Executive Advisory Team.</p>
    </div>
</section>

<section class="section investor-section">
    <div class="shell investor-grid">
        <div class="contact-details" data-reveal>
            <h2>Headquarters</h2>
            <div class="contact-item">
                <span class="contact-item__icon" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><path d="M16 29s8-9.2 8-17a8 8 0 1 0-16 0c0 7.8 8 17 8 17Z" fill="currentColor"/><circle cx="16" cy="12" r="3.2" fill="#fff"/></svg>
                </span>
                <div><b>Cyprus Office</b><p>Archiepiskopou Makariou III<br>Limassol, Cyprus</p></div>
            </div>
            <div class="contact-item">
                <span class="contact-item__icon" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><path d="M3 7h26v18H3Z" fill="currentColor"/><path d="m4 8 12 9L28 8M4 24l8.7-8M28 24l-8.7-8" fill="none" stroke="#fff" stroke-width="1.7" stroke-linejoin="round"/></svg>
                </span>
                <div><b>Direct Inquiries</b><p><a href="mailto:info@roxelinvest.com">info@roxelinvest.com</a></p></div>
            </div>
            <div class="contact-item">
                <span class="contact-item__icon" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><path d="M8.2 3.5 14 10l-3.5 4.2c2.3 4.5 4.8 7 9.3 9.3L24 20l6.5 5.8-3.4 4.1C14.2 31.2.8 17.8 2.1 4.9Z" fill="currentColor"/></svg>
                </span>
                <div><b>Telephone</b><p>+000 000 25 357</p></div>
            </div>
        </div>

        <div class="consultation-card" data-reveal>
            <h2>Schedule a Consultation</h2>
            <div class="title-rule title-rule--left" aria-hidden="true"></div>

            @if(session('success'))
                <div class="form-alert form-alert--success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="form-alert form-alert--error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="form-alert form-alert--error">Please review the highlighted fields and try again.</div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="consultation-form">
                @csrf
                <div class="honeypot" aria-hidden="true">
                    <label for="b_website">Website</label>
                    <input id="b_website" type="text" name="b_website" tabindex="-1" autocomplete="off">
                </div>

                <div class="form-grid form-grid--two">
                    <label>First Name
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                    </label>
                    <label>Last Name
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                    </label>
                </div>
                <div class="form-grid form-grid--two">
                    <label>Phone Number
                        <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                    </label>
                    <label>Email
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </label>
                </div>
                <label>Area of Interest
                    <select name="interest" required>
                        <option value="" @selected(old('interest', '') === '')></option>
                        <option value="Investment Portfolio" @selected(old('interest') === 'Investment Portfolio')>Investment Portfolio</option>
                        <option value="Cyprus Permanent Residency" @selected(old('interest') === 'Cyprus Permanent Residency')>Cyprus Permanent Residency</option>
                        <option value="Bespoke Services" @selected(old('interest') === 'Bespoke Services')>Bespoke Services</option>
                        <option value="General Inquiry" @selected(old('interest') === 'General Inquiry')>General Inquiry</option>
                    </select>
                </label>
                <label>Message
                    <textarea name="message" rows="5" placeholder="Notes" required>{{ old('message') }}</textarea>
                </label>
                <button class="button button--navy button--full" type="submit">Submit Inquiry</button>
            </form>
        </div>
    </div>
</section>
@endsection
