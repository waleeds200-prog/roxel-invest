@extends('layouts.app')
@section('title', 'Our DNA | ROXEL INVEST')
@section('meta_description', 'Architectural integrity, strategic vision and Cypriot heritage define the Roxel Invest development philosophy.')
@section('body_class', 'page-dna')

@section('content')
<section class="hero hero--inner hero--dna" style="--hero-image: url('{{ asset('assets/rox2026/images/hero-dna-bespoke.png') }}')">
    <div class="hero__shade"></div>
    <svg class="hero__motif hero__motif--inner-exact" viewBox="0 0 1920 932" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path transform="translate(-1060 0)" d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z" />
    </svg>
    <div class="hero__content shell" data-reveal>
        <h1>Our DNA</h1>
        <p class="hero__intro"><span class="desktop-only">Architectural Integrity. Strategic Vision. Cypriot Heritage.<br>elite clientele.</span><span class="mobile-only">Architectural Integrity. Strategic Vision.<br> Cypriot Heritage.<br> elite clientele.</span></p>
    </div>
</section>

<section class="dna-section" aria-labelledby="corporate-identity-title">
    <div class="dna-layout">
        <header class="dna-intro" data-reveal>
            <h2 id="corporate-identity-title">Corporate Identity</h2>
            <div class="title-rule" aria-hidden="true"></div>
            <p>A legacy of architectural integrity, sustainable luxury, and strategic vision in the Mediterranean real estate market</p>
        </header>

        <div class="dna-timeline">
            <article class="dna-step" data-reveal>
                <span class="dna-step__dot" aria-hidden="true"></span>
                <p class="mobile-only mobile-section-label">01 / The Executive Vision</p>
                <h3><em>I.</em> The Executive Vision</h3>
                <p>At the core of Roxel Invest is a commitment to redefining the luxury landscape of Paphos. We do not merely construct buildings; we curate environments that harmonize modern architectural innovation with the timeless character of the Cypriot coastline. Our expansion is driven by a singular objective: to deliver high-value assets that offer both aesthetic excellence and long-term investment security.</p>
            </article>

            <article class="dna-step dna-step--philosophy" data-reveal>
                <span class="dna-step__dot" aria-hidden="true"></span>
                <p class="mobile-only mobile-section-label">02 / Our Development Philosophy</p>
                <h3><em>II.</em> Our Development Philosophy</h3>
                <p class="desktop-only">Our approach is characterized by Administrative Rigor and Design Precision. Every project in our €12 Million portfolio is the result of a meticulous selection process, focusing on:</p>
                <p class="mobile-only">From tenant sourcing to full-scale maintenance, our dedicated property management arm ensures your investment remains pristine and highly lucrative, completely hands-free.</p>
                <div class="dna-pillars">
                    <div>
                        <span class="dna-pillar__icon" aria-hidden="true">
                            <img src="{{ asset('assets/rox2026/icons/dna-strategic-placement.svg') }}" alt="">
                        </span>
                        <p><b>Strategic Placement</b><br>Identifying prime coastal and hillside locations that guarantee capital appreciation.</p>
                    </div>
                    <div>
                        <span class="dna-pillar__icon" aria-hidden="true">
                            <img src="{{ asset('assets/rox2026/icons/dna-sustainable-luxury.svg') }}" alt="">
                        </span>
                        <p><b>Sustainable Luxury</b><br>Integrating eco-conscious building technologies without compromising on the high-end finishes expected by our global clientele.</p>
                    </div>
                    <div>
                        <span class="dna-pillar__icon" aria-hidden="true">
                            <img src="{{ asset('assets/rox2026/icons/dna-fiduciary-responsibility.svg') }}" alt="">
                        </span>
                        <p><b>Fiduciary Responsibility</b><br>Maintaining a transparent development lifecycle that ensures project milestones are met with clinical exactness.</p>
                    </div>
                </div>
            </article>

            <article class="dna-step" data-reveal>
                <span class="dna-step__dot" aria-hidden="true"></span>
                <p class="mobile-only mobile-section-label">03 / Leadership &amp; Governance</p>
                <h3><em>III.</em> Leadership &amp; Governance</h3>
                <p>Based in the heart of Paphos, our leadership team brings together decades of local market expertise and international business standards. This synergy allows us to navigate the complexities of the Cyprus real estate market with ease, providing our partners and clients with a seamless transition from acquisition to residency.</p>
            </article>
        </div>
    </div>
</section>
@endsection
