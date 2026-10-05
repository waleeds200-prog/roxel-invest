@extends('layouts.app')
@section('title', 'The Bespoke Experience | ROXEL INVEST')
@section('meta_description', 'Discover Roxel Invest after-sales, concierge, property management, interior design and residency services.')
@section('body_class', 'page-bespoke')

@section('content')
<section class="hero hero--inner hero--bespoke" style="--hero-image: url('{{ asset('assets/rox2026/images/hero-dna-bespoke.png') }}')">
    <div class="hero__shade"></div>
    <svg class="hero__motif hero__motif--inner-exact" viewBox="0 0 1920 932" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path transform="translate(-1060 0)" d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z" />
    </svg>
    <div class="hero__content shell" data-reveal>
        <p class="hero__eyebrow">Beyond Real Estate</p>
        <h1>The Bespoke Experience</h1>
        <p class="hero__intro">We take care of everything, so you don't have to. A curated<br>concierge and after-sales service designed for our elite clientele.</p>
    </div>
</section>

<section class="bespoke-services" aria-labelledby="curated-services-title">
    <div class="bespoke-shell">
        <header class="bespoke-heading" data-reveal>
            <h2 id="curated-services-title">Curated Services</h2>
            <div class="title-rule" aria-hidden="true"></div>
            <p>A comprehensive suite of after-sales and concierge services designed<br>exclusively for our elite clientele.</p>
        </header>

        <div class="service-grid">
            <article class="service-card" data-reveal>
                <span class="service-card__icon" aria-hidden="true">
                    <img src="{{ asset('assets/rox2026/icons/bespoke-property-management.svg') }}" alt="">
                </span>
                <h3>Property Management</h3>
                <p>From tenant sourcing to full-scale maintenance, our dedicated property management arm ensures your investment remains pristine and highly lucrative, completely hands-free.</p>
            </article>

            <article class="service-card" data-reveal>
                <span class="service-card__icon" aria-hidden="true">
                    <img src="{{ asset('assets/rox2026/icons/bespoke-interior-partnerships.svg') }}" alt="">
                </span>
                <h3>Interior Design Partnerships</h3>
                <p>We collaborate with Europe's finest interior design studios to furnish your home. Turnkey solutions that blend Mediterranean aesthetics with uncompromising luxury.</p>
            </article>

            <article class="service-card" data-reveal>
                <span class="service-card__icon" aria-hidden="true">
                    <img src="{{ asset('assets/rox2026/icons/bespoke-legal-residency.svg') }}" alt="">
                </span>
                <h3>Legal &amp; Residency</h3>
                <p>Seamless navigation of the Cyprus Permanent Residency (PR) program. Our in-house legal experts handle all administrative, tax, and residency paperwork on your behalf.</p>
            </article>
        </div>

        <div class="concierge" data-reveal>
            <figure class="concierge__media">
                <img src="{{ asset('assets/rox2026/images/bespoke-art.png') }}" alt="Abstract blue, magenta and red light artwork" loading="lazy" decoding="async">
            </figure>
            <div class="concierge__copy">
                <span class="outline-label">Uncompromising Service</span>
                <h2>A Hand-Holding<br><span>Experience</span></h2>
                <p>Luxury is not just in the architecture; it is in the peace of mind. Whether you are relocating your family or managing a high-yield asset from abroad, our Concierge team acts as your personal proxy in Cyprus.</p>
                <ul>
                    <li>Private Airport Transfers</li>
                    <li>Utility Setup &amp; Administration</li>
                    <li>VIP Lifestyle Management</li>
                </ul>
                <a class="button button--navy" href="{{ route('contact') }}">Contact Concierge</a>
            </div>
        </div>
    </div>
</section>
@endsection
