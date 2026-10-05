@extends('layouts.app')
@section('title', 'The Collection | ROXEL INVEST')
@section('meta_description', 'Explore the Roxel Invest collection: City Panorama, Olea Mare and Amathos Residences in Cyprus.')
@section('body_class', 'page-collection')

@php
    $projectGalleries = [
        'city-panorama' => [
            'title' => 'City Panorama',
            'images' => [
                ['src' => asset('assets/img/City_Panorama/city1.webp'), 'type' => 'Exterior — Street View'],
                ['src' => asset('assets/img/City_Panorama/city2.webp'), 'type' => 'Exterior — Front Elevation'],
                ['src' => asset('assets/img/City_Panorama/city3.webp'), 'type' => 'Exterior — Residential View'],
                ['src' => asset('assets/img/City_Panorama/city4.webp'), 'type' => 'Exterior — Architectural Detail'],
                ['src' => asset('assets/img/City_Panorama/city5.webp'), 'type' => 'Exterior — Side Elevation'],
                ['src' => asset('assets/img/City_Panorama/city6.webp'), 'type' => 'Exterior — Arrival View'],
            ],
        ],
        'olea-mare' => [
            'title' => 'Olea Mare',
            'images' => [
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Living_Room.webp'), 'type' => 'Interior — Living Room'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Kitchen.webp'), 'type' => 'Interior — Kitchen'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Bedroom.webp'), 'type' => 'Interior — Bedroom'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Staircase.webp'), 'type' => 'Interior — Staircase'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Front_exterior1.webp'), 'type' => 'Exterior — Front View'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/contemporary/contemporary_Terrace.webp'), 'type' => 'Exterior — Terrace'],
                ['src' => asset('assets/img/Olea Mare/Styles Photos/Night_Vibes/Night_Vibes_Outdoor.webp'), 'type' => 'Exterior — Night View'],
            ],
        ],
        'amathos-residences' => [
            'title' => 'Amathos Residences',
            'images' => [
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0001.webp'), 'type' => 'Exterior — Front Elevation'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0003.webp'), 'type' => 'Exterior — Arrival View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0004.webp'), 'type' => 'Exterior — Residential View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0005.webp'), 'type' => 'Exterior — Terrace View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0006.webp'), 'type' => 'Exterior — Architectural Detail'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0007.webp'), 'type' => 'Exterior — Side Elevation'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0008.webp'), 'type' => 'Exterior — Garden View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0009.webp'), 'type' => 'Exterior — Evening View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-00010.webp'), 'type' => 'Exterior — Detail View'],
                ['src' => asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-00011.webp'), 'type' => 'Exterior — Context View'],
            ],
        ],
    ];
    $oleaRoomDesigns = [
        ['Modern' => 'Modern/Modern_Living_Room.webp', 'Night Vibes' => 'Night_Vibes/Night_Vibes_Cozybohemian.webp'],
        ['Modern' => 'Modern/Modern_Kitchen.webp', 'Classic' => 'Classic/Classic_Kitchen.webp'],
        ['Modern' => 'Modern/Modern_Bedroom.webp', 'Classic' => 'Classic/Classic_Bedroom.webp'],
        ['Modern' => 'Modern/Modern_Staircase.webp', 'Classic' => 'Classic/Classic_Staircase.webp', 'Contemporary' => 'contemporary/contemporary_Staircase.webp'],
        ['Modern' => 'Modern/Modern_Front_exterior1.webp'],
        ['Classic' => 'Classic/Classic_Terrace.webp', 'Contemporary' => 'contemporary/contemporary_Terrace.webp', 'Night Vibes' => 'Night_Vibes/Night_Vibes_Terrace.webp'],
        ['Night Vibes' => 'Night_Vibes/Night_Vibes_Outdoor.webp'],
    ];

    foreach ($oleaRoomDesigns as $roomIndex => $designs) {
        $availableDesigns = [];
        foreach ($designs as $label => $file) {
            $path = 'assets/img/Olea Mare/Styles Photos/' . $file;
            if (is_file(public_path($path))) {
                $availableDesigns[] = ['label' => $label, 'src' => asset($path)];
            }
        }
        $projectGalleries['olea-mare']['images'][$roomIndex]['designs'] = $availableDesigns;
    }
@endphp

@section('content')
<section class="hero hero--inner hero--collection" style="--hero-image: url('{{ asset('assets/rox2026/images/collection-hero.jpg') }}')">
    <div class="hero__shade"></div>
    <svg class="hero__motif hero__motif--collection-exact" viewBox="0 0 1920 1081" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        {{-- Same flowing Bézier geometry as the approved Home arrow, translated to the page-2 artwork position. --}}
        <path transform="translate(-841.772 54.55)" d="M174.583 1674.557 C174.583 1674.557 998.575 1371.729 1614.031 464.192 L1461.934 395.299 L1917.772 211.450 L1854.047 662.705 L1739.302 553.175 C1742.376 562.498 880.462 1567.522 174.583 1674.557 Z" />
    </svg>
    <div class="hero__content shell" data-reveal>
        <p class="hero__eyebrow">A Portfolio of Distinction.<br>From Concept to Landmark.</p>
        <h1>The <span>Collection</span></h1>
        <p class="hero__intro">Our current €12 Million portfolio represents a diverse array of luxury living, seamlessly blending modern aesthetics with the rugged beauty of the Cypriot coastline.</p>
    </div>
</section>

<section class="section collection-section" aria-labelledby="projects-title">
    <div class="shell">
        <div class="collection-spotlight" data-reveal>
            <p class="collection-spotlight__eyebrow">PROJECT SPOTLIGHT</p>
            <h2>Olea Mare</h2>
            <div class="collection-spotlight__rule" aria-hidden="true"></div>
            <p class="collection-spotlight__intro">Discover a new perspective<br>on coastal living</p>
        </div>

        <div class="collection-video">
            <video controls playsinline preload="metadata" tabindex="0" poster="{{ asset('assets/img/Olea Mare/Styles Photos/Night_Vibes/Night_Vibes_Outdoor.webp') }}" aria-label="Olea Mare project video">
                <source src="{{ asset('assets/video/Olea_Mare.mp4') }}" type="video/mp4">
                Your browser does not support embedded video.
                <a href="{{ asset('assets/video/Olea_Mare.mp4') }}">Watch the Olea Mare video</a>.
            </video>
            <button class="collection-video__play" type="button" aria-label="Play Olea Mare video" hidden>
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8 5v14l11-7z" /></svg>
            </button>
        </div>

        <div class="section-heading section-heading--center" data-reveal>
            <h2 id="projects-title">Projects</h2>
            <div class="title-rule" aria-hidden="true"></div>
        </div>

        <div class="project-grid">
            <article class="project-card" data-gallery="city-panorama" data-reveal>
                <div class="project-card__image">
                    <button type="button" class="project-card__gallery-trigger" aria-label="Open City Panorama image gallery">
                        <img src="{{ asset('assets/img/City_Panorama/city1.webp') }}" alt="City Panorama residence" loading="lazy" decoding="async">
                    </button>
                    <button type="button" class="project-card__heart" aria-label="Save City Panorama" aria-pressed="false">♡</button>
                </div>
                <div class="project-card__body">
                    <p class="project-card__type">Project Selection</p>
                    <div class="project-card__title-row"><h3>City Panorama</h3><span class="segmented-rule segmented-rule--flex" aria-hidden="true"></span></div>
                    <p>A boutique collection of sea-view apartments in the most sought-after neighbourhood in the Paphos district, characterised by open-plan fluidity and seamless indoor-outdoor transitions.</p>
                    <p class="project-card__status"><span>Status:</span> Available</p>
                    <h4>Key Features:</h4>
                    <ul>
                        <li>216.90 m² Total Built Area Per Floor</li>
                        <li>1,106.30 m² Total Building Area</li>
                    </ul>
                </div>
            </article>

            <article class="project-card" data-gallery="olea-mare" data-reveal>
                <div class="project-card__image">
                    <button type="button" class="project-card__gallery-trigger" aria-label="Open Olea Mare image gallery">
                        <img src="{{ asset('assets/img/Olea Mare/Styles Photos/Modern/Modern_Living_Room.webp') }}" alt="Olea Mare luxury living room" loading="lazy" decoding="async">
                    </button>
                    <button type="button" class="project-card__heart" aria-label="Save Olea Mare" aria-pressed="false">♡</button>
                </div>
                <div class="project-card__body">
                    <p class="project-card__type">Coastal Living</p>
                    <div class="project-card__title-row"><h3>Olea Mare</h3><span class="segmented-rule segmented-rule--flex" aria-hidden="true"></span></div>
                    <p>Strategically elevated to capture the cooling breezes of the Akamas foothills, these residences offer a retreat from the vibrant city center.</p>
                    <p class="project-card__status"><span>Status:</span> Available</p>
                    <h4>Key Features:</h4>
                    <ul>
                        <li>Total Plot Area: 1,724 m²</li>
                        <li>Total Covered Area: 398 m²</li>
                        <li>Top-of-the-line equipment and interior finishes</li>
                    </ul>
                </div>
            </article>

            <article class="project-card" data-gallery="amathos-residences" data-reveal>
                <div class="project-card__image">
                    <button type="button" class="project-card__gallery-trigger" aria-label="Open Amathos Residences image gallery">
                        <img src="{{ asset('assets/img/Amathos_Photos/AMATHOS_Photos_page-0001.webp') }}" alt="Amathos Residences exterior" loading="lazy" decoding="async">
                    </button>
                    <button type="button" class="project-card__heart" aria-label="Save Amathos Residences" aria-pressed="false">♡</button>
                </div>
                <div class="project-card__body">
                    <p class="project-card__type">The New Riviera</p>
                    <div class="project-card__title-row"><h3>Amathos Residences</h3><span class="segmented-rule segmented-rule--flex" aria-hidden="true"></span></div>
                    <p>An ambitious integration of residential luxury and lifestyle amenities, setting a new benchmark for “The New Riviera.”</p>
                    <p class="project-card__status"><span>Status:</span> Available</p>
                    <h4>Key Features:</h4>
                    <ul>
                        <li>Total covered area 175 m²</li>
                        <li>Covered verandas 29 m²</li>
                        <li>Walking distance to the beach</li>
                    </ul>
                </div>
            </article>
        </div>

        <div class="section-cta" data-reveal>
            <a class="button button--navy" href="{{ route('contact') }}">View All Properties <span>→</span></a>
        </div>
    </div>
</section>

<div class="collection-lightbox" id="collection-lightbox" hidden role="dialog" aria-modal="true" aria-labelledby="collection-lightbox-title">
    <div class="collection-lightbox__backdrop" data-lightbox-close></div>
    <div class="collection-lightbox__dialog">
        <header class="collection-lightbox__header">
            <div>
                <p id="collection-lightbox-title">Project Gallery</p>
                <strong id="collection-lightbox-project"></strong>
            </div>
            <div class="collection-lightbox__meta">
                <span id="collection-lightbox-type"></span>
                <span id="collection-lightbox-counter"></span>
            </div>
            <button type="button" class="collection-lightbox__close" data-lightbox-close aria-label="Close image gallery">×</button>
        </header>
        <div class="collection-lightbox__stage">
            <button type="button" class="collection-lightbox__nav collection-lightbox__nav--prev" data-lightbox-prev aria-label="Previous image">←</button>
            <figure>
                <img id="collection-lightbox-image" src="" alt="">
                <figcaption id="collection-lightbox-caption"></figcaption>
            </figure>
            <button type="button" class="collection-lightbox__nav collection-lightbox__nav--next" data-lightbox-next aria-label="Next image">→</button>
        </div>
        <div class="collection-lightbox__designs" id="collection-lightbox-designs" hidden>
            <label for="collection-lightbox-room">Room / View</label>
            <select id="collection-lightbox-room"></select>
            <div class="collection-lightbox__design-options" id="collection-lightbox-design-options" role="group" aria-label="Available designs for this room"></div>
        </div>
        <div class="collection-lightbox__progress" id="collection-lightbox-progress" aria-hidden="true"></div>
    </div>
</div>

<script id="collection-gallery-data" type="application/json">@json($projectGalleries)</script>
@endsection
