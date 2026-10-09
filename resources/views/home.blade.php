@extends('layouts.app')
@section('title', 'Paphos: The New Riviera | ROXEL INVEST')
@section('meta_description', 'Discover Roxel Invest’s luxury real-estate portfolio in Cyprus, from coastal residences to strategic investment opportunities in Paphos.')
@section('body_class', 'page-home')

@section('content')
<section class="hero hero--home" style="--hero-image: url('{{ asset('assets/rox2026/images/hero-home-clean.webp') }}')">
    {{-- Exact vector geometry extracted from page 1 of the approved PDF/AI artwork. --}}
    <svg class="hero__motif hero__motif--exact" viewBox="0 0 1920 1081" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z"/>
    </svg>
    <div class="hero__shade"></div>
    <div class="hero__content shell" data-reveal>
        <h1>Paphos: <span>The New Riviera</span></h1>
        <p class="hero__lead">Discover the island’s most<br>compelling investment frontier</p>
        <div class="hero__actions">
            <a class="button button--outline" href="{{ route('services') }}">Explore Collection</a>
            <a class="button button--gold" href="#investment-growth">Investment ROI</a>
        </div>
    </div>
</section>

<div class="mobile-only mobile-home-actions shell">
    <a class="button button--navy" href="{{ route('services') }}">Explore Collection <span aria-hidden="true">&rarr;</span></a>
    <a class="button button--gold" href="#investment-growth">Investment ROI <span aria-hidden="true">&rarr;</span></a>
</div>

<section class="section section--light" id="collection-highlights">
    <div class="shell">
        <div class="section-heading section-heading--center" data-reveal>
            <p class="kicker">The Collection</p>
            <h2>A Portfolio of Distinction</h2>
            <div class="title-rule" aria-hidden="true"></div>
            <p>Our current €12 Million portfolio represents a diverse array of luxury living, seamlessly blending modern aesthetics with the rugged beauty of the Cypriot coastline.</p>
        </div>

        <div class="section-cta desktop-only" data-reveal>
            <a class="button button--navy" href="{{ route('services') }}">View All Projects <span>→</span></a>
        </div>

        <div class="home-projects">
            <article class="feature-project" data-reveal>
                <div class="feature-project__media">
                    <picture><source media="(max-width: 560px)" srcset="{{ asset('assets/rox2026/images/mobile/coastal.webp') }}"><img src="{{ asset('assets/rox2026/images/coastal-sophistication.webp') }}" alt="Luxury coastal villa with swimming pool" loading="lazy" decoding="async"></picture>
                    <span class="vertical-tag vertical-tag--left">Limited Availability</span>
                </div>
                <div class="feature-project__copy">
                    <div class="feature-project__title-row"><h3>Coastal Sophistication</h3><span class="segmented-rule segmented-rule--flex" aria-hidden="true"></span></div>
                    <p>Boutique sea-front villas with unobstructed views, located minutes from elite marinas and championship golf courses.</p>
                    <a href="{{ route('services') }}"><span class="desktop-only">Discovery</span><span class="mobile-only">View Details</span> <span aria-hidden="true">→</span></a>
                </div>
            </article>

            <article class="feature-project" data-reveal>
                <div class="feature-project__media">
                    <picture><source media="(max-width: 560px)" srcset="{{ asset('assets/rox2026/images/mobile/city.webp') }}"><img src="{{ asset('assets/rox2026/images/city1.webp') }}" alt="Contemporary hillside apartment development" loading="lazy" decoding="async"></picture>
                    <span class="vertical-tag vertical-tag--right">Under Development</span>
                </div>
                <div class="feature-project__copy">
                    <div class="feature-project__title-row"><h3>The Hillside Sanctuary</h3><span class="segmented-rule segmented-rule--flex" aria-hidden="true"></span></div>
                    <p>Strategically elevated to capture the cooling breezes of the Akamas foothills.</p>
                    <a href="{{ route('services') }}"><span class="desktop-only">Discovery</span><span class="mobile-only">View Details</span> <span aria-hidden="true">→</span></a>
                </div>
            </article>
        </div>
        <div class="section-cta mobile-only" data-reveal>
            <a class="button button--navy" href="{{ route('services') }}">View All Projects <span>→</span></a>
        </div>
    </div>
</section>

<section class="section growth" id="investment-growth">
    <div class="shell growth__grid">
        <div class="growth__copy" data-reveal>
            <p class="kicker">Strategic Growth</p>
            <h2>Performance. Transparency.<br><span>Scalable Growth.</span></h2>
            <p>We believe the Paphos market offers a unique “alpha” opportunity—high capital appreciation potential paired with Eurozone legal protections.</p>

            <div class="growth__stats">
                <div><strong>€12M</strong><span>Portfolio Valuation</span></div>
                <div><strong>Alpha</strong><span>Yield Potential</span></div>
            </div>

            <a class="button button--gold" href="{{ route('contact') }}">View Investment Thesis</a>
        </div>

        <div class="growth__drivers" data-reveal>
            <article>
                <h3>Infrastructure Maturation</h3>
                <p>Airport expansion and new highways unlocking accessibility.</p>
            </article>
            <article>
                <h3>The Innovation Hub</h3>
                <p>Arrival of AUB and CUT campuses driving long-term rental demand.</p>
            </article>
            <article>
                <h3>The Safety Index</h3>
                <p>Consistently ranked as one of the safest cities in Europe.</p>
            </article>
        </div>
    </div>
</section>

<section class="section eu-gateway">
    <div class="shell eu-gateway__grid">
        <figure class="eu-gateway__image" data-reveal>
            <picture><source media="(max-width: 560px)" srcset="{{ asset('assets/rox2026/images/mobile/surfer.webp') }}"><img src="{{ asset('assets/rox2026/images/surfer-hq.webp') }}" alt="Surfer on a Mediterranean wave" loading="lazy" decoding="async"></picture>
        </figure>
        <div class="eu-gateway__copy" data-reveal>
            <h2>Gateway to the European Union</h2>
            <div class="title-rule title-rule--left" aria-hidden="true"></div>
            <p>For our international clientele, Paphos serves as the ultimate administrative gateway to Europe. Investment in our developments qualifies for the Cyprus Permanent Residency program.</p>
            <ul>
                <li>Permanent Residency (PR) Pathway</li>
                <li>Fiscal Stability &amp; VAT Incentives</li>
                <li>Strict Environmental Integrity</li>
            </ul>
            <a class="button button--gold" href="{{ route('about') }}">Our Development Philosophy <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>
@endsection
