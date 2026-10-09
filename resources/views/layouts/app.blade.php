<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#08122b">

    <title>@yield('title', 'ROXEL INVEST | Luxury Real Estate in Cyprus')</title>
    <meta name="description" content="@yield('meta_description', 'Roxel Invest develops distinctive luxury residences and real-estate investment opportunities in Cyprus.')">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/LOGO3.png') }}">
    <meta property="og:title" content="@yield('title', 'ROXEL INVEST | Luxury Real Estate in Cyprus')">
    <meta property="og:description" content="@yield('meta_description', 'Roxel Invest develops distinctive luxury residences and real-estate investment opportunities in Cyprus.')">
    <meta property="og:image" content="{{ asset('assets/rox2026/images/hero-home.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet" media="(min-width: 561px)">
    <link rel="stylesheet" href="{{ asset('assets/css/rox-redesign.css') }}?v={{ filemtime(public_path('assets/css/rox-redesign.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rox-mobile.css') }}?v={{ filemtime(public_path('assets/css/rox-mobile.css')) }}" media="(max-width: 560px)">
    <link rel="preload" as="font" href="{{ asset('assets/rox2026/fonts/avenir-medium-mobile.ttf') }}" type="font/ttf" crossorigin media="(max-width: 560px)">
    <link rel="preload" as="font" href="{{ asset('assets/rox2026/fonts/PERB____.TTF') }}" type="font/ttf" crossorigin media="(max-width: 560px)">
    @stack('head')
</head>
<body class="@yield('body_class')">
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header" id="site-header">
        <div class="site-header__inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Roxel Invest home">
                <img src="{{ asset('assets/img/LOGO3.png') }}" alt="Roxel Invest">
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('about') ? 'is-active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif href="{{ route('about') }}">Our DNA</a>
                <a class="{{ request()->routeIs('services') ? 'is-active' : '' }}" @if(request()->routeIs('services')) aria-current="page" @endif href="{{ route('services') }}">The Collection</a>
                <a class="{{ request()->routeIs('bespoke') ? 'is-active' : '' }}" @if(request()->routeIs('bespoke')) aria-current="page" @endif href="{{ route('bespoke') }}">Bespoke</a>
                <a class="{{ request()->routeIs('contact') ? 'is-active' : '' }}" @if(request()->routeIs('contact')) aria-current="page" @endif href="{{ route('contact') }}">Investor Relations</a>
            </nav>

            <button class="menu-toggle" id="menu-toggle" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <div class="menu-backdrop" id="menu-backdrop" aria-hidden="true"></div>
    <aside class="mobile-menu" id="mobile-menu" role="dialog" aria-label="Site navigation" aria-modal="true" aria-hidden="true" inert>
        <button class="mobile-menu__close" id="menu-close" type="button" aria-label="Close navigation">×</button>
        <svg class="mobile-menu__motif" viewBox="0 0 1920 1081" preserveAspectRatio="none" aria-hidden="true" focusable="false">
            <path d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z"/>
        </svg>

        <div class="mobile-menu__frame">
            <a class="mobile-menu__brand" href="{{ route('home') }}" aria-label="Roxel Invest home">
                <img src="{{ asset('assets/img/LOGO3.png') }}" alt="Roxel Invest">
            </a>

            <div class="mobile-menu__content">
                <nav aria-label="Site navigation">
                    <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif href="{{ route('home') }}"><span>Home</span></a>
                    <a class="{{ request()->routeIs('about') ? 'is-active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif href="{{ route('about') }}"><span>Our DNA</span></a>
                    <a class="{{ request()->routeIs('services') ? 'is-active' : '' }}" @if(request()->routeIs('services')) aria-current="page" @endif href="{{ route('services') }}"><span>The Collection</span></a>
                    <a class="{{ request()->routeIs('bespoke') ? 'is-active' : '' }}" @if(request()->routeIs('bespoke')) aria-current="page" @endif href="{{ route('bespoke') }}"><span>Bespoke</span></a>
                    <a class="{{ request()->routeIs('contact') ? 'is-active' : '' }}" @if(request()->routeIs('contact')) aria-current="page" @endif href="{{ route('contact') }}"><span>Investor Relations</span></a>
                </nav>

                <a class="mobile-menu__cta" href="{{ route('contact') }}">Schedule a Consultation <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="mobile-menu__meta">
                <div>
                    <span>Direct Inquiries</span>
                    <a href="mailto:info@roxelinvest.com">info@roxelinvest.com</a>
                </div>
                <div>
                    <span>ROXEL INVEST</span>
                    <small>Building tomorrow's landmarks today.</small>
                </div>
            </div>
        </div>
    </aside>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-footer__inner">
            <div>
                <h2>ROXEL INVEST</h2>
                <p>Building tomorrow's landmarks today.</p>
            </div>
            <div>
                <h3>Contact Info</h3>
                <p>Archiepiskopou Makariou III, Limassol</p>
                <a href="mailto:info@roxelinvest.com">info@roxelinvest.com</a>
                <nav class="mobile-only footer-mobile-nav" aria-label="Footer navigation">
                    <div><a href="{{ route('home') }}">Home</a> / <a href="{{ route('about') }}">Our DNA</a> / <a href="{{ route('services') }}">The Collection</a></div>
                    <div><a href="{{ route('bespoke') }}">Bespoke</a> / <a href="{{ route('contact') }}">Investor Relations</a></div>
                </nav>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/rox-redesign.js') }}?v={{ filemtime(public_path('assets/js/rox-redesign.js')) }}" defer></script>
    @stack('scripts')
</body>
</html>
