@extends('layouts.app')

@section('title', 'Enabling value-sharing and adoption of health data business models')
@section('description', 'VALUEMAP connects European health data ecosystems to develop sustainable business models, practical tools and coordinated actions for the responsible secondary use of health data.')
@section('body_class', 'home-page')

@section('content')
<section class="hero">
    <svg class="hero-background hero-background-map" viewBox="0 0 1150 620" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
        <defs>
            <linearGradient id="hero-map-background" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#061b2d" />
                <stop offset=".58" stop-color="#0a3555" />
                <stop offset="1" stop-color="#1266b3" />
            </linearGradient>
            <pattern id="hero-map-grid" width="38" height="38" patternUnits="userSpaceOnUse">
                <path d="M38 0H0V38" fill="none" stroke="#d7eef5" stroke-opacity=".055" stroke-width="1" />
            </pattern>
        </defs>
        <rect width="1150" height="620" fill="url(#hero-map-background)" />
        <rect width="1150" height="620" fill="url(#hero-map-grid)" />
        <g class="hero-europe-countries" transform="translate(250 0)">
            @include('partials.europe-map')
        </g>
    </svg>
    <div class="hero-shade" aria-hidden="true"></div>
    <svg class="hero-network hero-network-desktop" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <defs>
            <linearGradient id="hero-network-gradient" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stop-color="#78cbd2" stop-opacity=".18" />
                <stop offset=".52" stop-color="#d7eef5" stop-opacity=".9" />
                <stop offset="1" stop-color="#78cbd2" stop-opacity=".2" />
            </linearGradient>
        </defs>
        <g class="hero-network-routes">
            <path id="hero-route-1" d="M58 35 C61 31 63 30 66 31" />
            <path id="hero-route-2" d="M66 31 C68 34 70 39 72 42" />
            <path id="hero-route-3" d="M72 42 C75 41 77 39 79 37" />
            <path id="hero-route-4" d="M79 37 C82 39 83 45 84 49" />
            <path id="hero-route-5" d="M58 35 C59 42 61 48 63 52" />
            <path id="hero-route-6" d="M63 52 C66 54 70 56 73 58" />
            <path id="hero-route-7" d="M73 58 C78 59 83 60 88 61" />
            <path id="hero-route-8" d="M72 42 C77 43 81 46 84 49" />
        </g>
        <g class="hero-network-travellers">
            <circle r=".32"><animateMotion dur="5.8s" begin="-.8s" repeatCount="indefinite"><mpath href="#hero-route-1" /></animateMotion></circle>
            <circle r=".28"><animateMotion dur="6.6s" begin="-3.1s" repeatCount="indefinite"><mpath href="#hero-route-2" /></animateMotion></circle>
            <circle r=".3"><animateMotion dur="5.4s" begin="-1.9s" repeatCount="indefinite"><mpath href="#hero-route-3" /></animateMotion></circle>
            <circle r=".26"><animateMotion dur="7.2s" begin="-4.4s" repeatCount="indefinite"><mpath href="#hero-route-4" /></animateMotion></circle>
            <circle r=".3"><animateMotion dur="6.9s" begin="-2.2s" repeatCount="indefinite"><mpath href="#hero-route-5" /></animateMotion></circle>
            <circle r=".27"><animateMotion dur="5.9s" begin="-4.8s" repeatCount="indefinite"><mpath href="#hero-route-6" /></animateMotion></circle>
            <circle r=".3"><animateMotion dur="7.8s" begin="-3.6s" repeatCount="indefinite"><mpath href="#hero-route-7" /></animateMotion></circle>
            <circle r=".25"><animateMotion dur="6.3s" begin="-1.2s" repeatCount="indefinite"><mpath href="#hero-route-8" /></animateMotion></circle>
        </g>
    </svg>
    <svg class="hero-network hero-network-mobile" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <defs>
            <linearGradient id="hero-network-gradient-mobile" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stop-color="#78cbd2" stop-opacity=".18" />
                <stop offset=".52" stop-color="#d7eef5" stop-opacity=".9" />
                <stop offset="1" stop-color="#78cbd2" stop-opacity=".2" />
            </linearGradient>
        </defs>
        <g class="hero-network-routes">
            <path id="hero-mobile-route-1" d="M74 29 C79 28 84 31 88 34" />
            <path id="hero-mobile-route-2" d="M88 34 C86 37 84 40 81 43" />
            <path id="hero-mobile-route-3" d="M74 29 C76 34 78 39 81 43" />
        </g>
        <g class="hero-network-travellers">
            <circle r=".42"><animateMotion dur="6.2s" begin="-1.4s" repeatCount="indefinite"><mpath href="#hero-mobile-route-1" /></animateMotion></circle>
            <circle r=".4"><animateMotion dur="7s" begin="-4s" repeatCount="indefinite"><mpath href="#hero-mobile-route-2" /></animateMotion></circle>
            <circle r=".38"><animateMotion dur="6.6s" begin="-2.8s" repeatCount="indefinite"><mpath href="#hero-mobile-route-3" /></animateMotion></circle>
        </g>
    </svg>
    <div class="hero-pulses" aria-hidden="true">
        @foreach([[58,35,'.2s',7],[66,31,'1.1s',6],[72,42,'.6s',8],[79,37,'1.8s',6],[84,49,'.9s',8],[63,52,'1.5s',7],[73,58,'.35s',6],[88,61,'2.2s',7]] as $pulse)
            <i style="--x:{{ $pulse[0] }}%;--y:{{ $pulse[1] }}%;--delay:{{ $pulse[2] }};--size:{{ $pulse[3] }}px"></i>
        @endforeach
    </div>
    <div class="hero-grid">
        <div class="hero-copy reveal">
            <div class="hero-project-logo">
                <img src="{{ asset('images/brand/valuemap-logo.webp') }}" alt="VALUEMAP project" width="725" height="130" decoding="async">
            </div>
            <p class="eyebrow"><span></span> Horizon Europe project</p>
            <h1>Enabling value-sharing and adoption of <em>health data</em> business models.</h1>
            <p class="hero-lede">Building a more connected, inclusive and sustainable European health data ecosystem.</p>
            <p class="hero-description">VALUEMAP supports fair, ethical and sustainable business models for the secondary use of health data—turning its potential into shared value for European health systems and society.</p>
            <div class="hero-actions">
                <a class="button" href="{{ route('about') }}">Discover VALUEMAP <span>↗</span></a>
                <a class="text-link" href="{{ route('structure') }}">Explore our work <span>↓</span></a>
                <a class="text-link" href="{{ route('results') }}">Project resources <span>↗</span></a>
            </div>
        </div>
        <div class="hero-insight reveal" aria-label="VALUEMAP project scope">
            <div class="hero-insight-head"><span>European collaboration</span><i aria-hidden="true"></i></div>
            <p>Connecting regional intelligence, stakeholder experience and coordinated action.</p>
            <div class="hero-insight-grid"><span><small>Organisations</small><strong>09</strong></span><span><small>Countries</small><strong>06</strong></span><span><small>Focus</small><strong>Shared value</strong></span></div>
            <a href="{{ route('consortium') }}">Meet the consortium <span>↗</span></a>
        </div>
    </div>
    <div class="project-facts" aria-label="Project at a glance">
        <div><span>01</span><small>Duration</small><strong>18 months</strong></div>
        <div><span>02</span><small>Consortium</small><strong>9 organisations</strong></div>
        <div><span>03</span><small>Geography</small><strong>6 countries</strong></div>
        <div><span>04</span><small>Grant type</small><strong>Horizon Europe CSA</strong></div>
    </div>
</section>

<section class="visual-story" data-story-slider aria-label="VALUEMAP project story">
    <div class="visual-story-heading reveal"><p class="eyebrow">The project in focus</p><h2>From potential to <em>shared value.</em></h2><p>Understanding the landscape, connecting stakeholders and translating evidence into coordinated European action.</p></div>
    <div class="story-stage" tabindex="0">
        @foreach([
            ['01 / Map','story-map.jpg','Digital globe representing connected data ecosystems','Understand the landscape.','Map existing business models, initiatives, practices, opportunities and challenges across Europe.',route('about'),2400,1600],
            ['02 / Connect','story-connect.jpg','People joining hands inside a connected global network','Bring perspectives together.','Connect regions, healthcare, policy, research, industry and citizens around shared priorities.',route('ecosystem'),2400,1600],
            ['03 / Act','story-act.jpg','Interconnected network reflected across a calm surface','Turn evidence into action.','Create recommendations, a joint action plan and practical implementation tools.',route('impact'),2400,1600],
        ] as $i => $slide)
        <article @class(['story-slide','is-active'=>$i===0]) data-story-slide aria-hidden="{{ $i===0 ? 'false' : 'true' }}">
            <img src="{{ asset('images/visuals/'.$slide[1]) }}" alt="{{ $slide[2] }}" width="{{ $slide[6] }}" height="{{ $slide[7] }}" decoding="async" @if($i) loading="lazy" @endif>
            <div class="story-slide-shade"></div><div class="story-slide-content"><span>{{ $slide[0] }}</span><h3>{{ $slide[3] }}</h3><p>{{ $slide[4] }}</p><a href="{{ $slide[5] }}">Learn more ↗</a></div>
        </article>
        @endforeach
        <div class="story-controls" aria-label="Slideshow controls"><div class="story-dots">@for($i=0;$i<3;$i++)<button @class(['is-active'=>$i===0]) type="button" data-story-dot="{{ $i }}" aria-label="Show slide {{ $i+1 }}" @if($i===0) aria-current="true" @endif></button>@endfor</div><div class="story-arrows"><button type="button" data-story-prev aria-label="Previous slide">←</button><button type="button" data-story-next aria-label="Next slide">→</button></div></div>
    </div>
</section>

<section class="section intro-section" id="about">
    <div class="section-heading"><p class="eyebrow">01 / Why VALUEMAP?</p><h2>Creating the conditions for <em>shared value</em> from health data.</h2></div>
    <div class="intro-ecg" aria-hidden="true">
        <svg viewBox="0 0 1200 150" preserveAspectRatio="none" focusable="false">
            <defs>
                <linearGradient id="intro-ecg-gradient" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#78cbd2" />
                    <stop offset=".55" stop-color="#1266b3" />
                    <stop offset="1" stop-color="#78cbd2" />
                </linearGradient>
            </defs>
            <path class="intro-ecg-track" pathLength="1" d="M0 76 H150 L178 76 L197 56 L217 100 L241 18 L268 128 L292 52 L316 76 H468 L490 76 L507 60 L525 94 L548 30 L572 116 L596 57 L618 76 H775 L799 76 L816 54 L837 101 L860 20 L886 126 L910 53 L934 76 H1200" />
            <path class="intro-ecg-signal" pathLength="1" d="M0 76 H150 L178 76 L197 56 L217 100 L241 18 L268 128 L292 52 L316 76 H468 L490 76 L507 60 L525 94 L548 30 L572 116 L596 57 L618 76 H775 L799 76 L816 54 L837 101 L860 20 L886 126 L910 53 L934 76 H1200" />
        </svg>
    </div>
    <div class="intro-grid"><div class="large-copy">Health data can accelerate research, strengthen health systems and enable better products, services and policies.</div><div><p>Its value is not yet fully realised. Differences in governance, access conditions, infrastructures, pricing, licensing and stakeholder capacities continue to limit collaboration and innovation.</p><p>VALUEMAP explores how health data ecosystems can create, share and sustain value in a fair, transparent and responsible way—supporting the ambition of the European Health Data Space.</p><a class="arrow-link" href="{{ route('about') }}">Read about the project <span>↗</span></a></div></div>
</section>

<section class="section activity-section">
    <div class="section-heading"><p class="eyebrow">02 / What is VALUEMAP?</p><h2>Six activities. <em>One connected approach.</em></h2></div>
    <div class="activity-grid">
        @foreach([
            ['Examine','Existing health data business models and practices.'],['Identify','Barriers and opportunities for secondary use.'],['Assess','Regional health data ecosystems and needs.'],['Promote','Cooperation between regions and stakeholders.'],['Develop','Recommendations, tools and joint actions.'],['Support','Long-term sustainability of health data initiatives.']
        ] as $i => $activity)
        <article class="reveal" tabindex="0" aria-labelledby="activity-title-{{ $i }}" aria-describedby="activity-description-{{ $i }}"><span>0{{ $i+1 }}</span><h3 id="activity-title-{{ $i }}">{{ $activity[0] }}</h3><p id="activity-description-{{ $i }}">{{ $activity[1] }}</p></article>
        @endforeach
    </div>
</section>

<section class="section process-section">
    <div class="section-heading"><p class="eyebrow">03 / From evidence to action</p><h2>A collaborative path from <em>mapping to implementation.</em></h2></div>
    <ol class="process-flow">
        @foreach([
            ['Map','Understand the European landscape.'],['Connect','Bring regions, sectors and expertise together.'],['Assess','Examine ecosystems, challenges and opportunities.'],['Co-create','Develop shared recommendations and priorities.'],['Act','Deliver a Joint Action Plan and Implementation Toolkit.']
        ] as $i => $step)
        <li class="reveal"><span>0{{ $i+1 }}</span><h3>{{ $step[0] }}</h3><p>{{ $step[1] }}</p></li>
        @endforeach
    </ol>
</section>

<section class="section dark-section" id="structure">
    <div class="section-heading heading-row"><div><p class="eyebrow">04 / Project structure</p><h2>Five work packages.<br><em>One shared direction.</em></h2></div><a class="button button-light" href="{{ route('structure') }}">Explore all work packages ↗</a></div>
    <div class="wp-preview wp-preview-five">@foreach(config('valuemap.work_packages') as $wp)<article><span>WP {{ $wp['number'] }}</span><h3>{{ $wp['title'] }}</h3><p>{{ $wp['lead'] }} · {{ $wp['duration'] }}</p></article>@endforeach</div>
</section>

<section class="section consortium-preview">
    <div class="section-heading heading-row"><div><p class="eyebrow">05 / Connecting European expertise</p><h2>Complementary expertise across <em>six countries.</em></h2></div><a class="arrow-link" href="{{ route('consortium') }}">Meet the Consortium <span>↗</span></a></div>
    <p class="section-intro">Nine organisations combine healthcare, research, digital health, public administration, innovation, industry and health data governance expertise.</p>
    <div class="partner-strip">@foreach($partners as $partner)<a href="{{ $partner->website_url ?: route('consortium') }}" @if($partner->website_url) target="_blank" rel="noopener" @endif>@if($partner->display_logo_url)<span class="has-logo"><img src="{{ $partner->display_logo_url }}" alt="" loading="lazy"></span>@else<span>{{ $partner->initials }}</span>@endif<strong>{{ $partner->name }}</strong><small>{{ $partner->country }}</small></a>@endforeach</div>
</section>

<section class="section ecosystem-preview">
    <div class="section-heading"><p class="eyebrow">06 / Stakeholder ecosystem</p><h2>One ecosystem. <em>Many perspectives.</em></h2></div>
    <div class="stakeholder-wheel">@foreach(config('valuemap.stakeholders') as $i => $group)<a href="{{ route('ecosystem') }}"><span>0{{ $i+1 }}</span><strong>{{ $group[0] }}</strong><i>↗</i></a>@endforeach</div>
</section>

<section class="section library-section" id="resources">
    <div class="section-heading heading-row"><div><p class="eyebrow">07 / Results & resources</p><h2>From project work to <em>practical resources.</em></h2></div><a class="arrow-link" href="{{ route('results') }}">Explore project resources <span>↗</span></a></div>
    <div class="content-grid">@forelse($latestResults as $item) @include('partials.content-card', ['item' => $item]) @empty <article class="empty-card"><span>Library opening soon</span><h3>Reports, recommendations, tools and other public resources will live here.</h3><p>The library will grow throughout project implementation.</p><a href="{{ route('results') }}">Visit the library →</a></article>@endforelse</div>
</section>

<section class="section news-section" id="news">
    <div class="section-heading heading-row"><div><p class="eyebrow">08 / Latest from VALUEMAP</p><h2>Follow the work <em>as it happens.</em></h2></div><a class="arrow-link" href="{{ route('news') }}">All updates <span>↗</span></a></div>
    <div class="news-list">@forelse($latestNews as $item)<a href="{{ route('content.show', $item) }}"><span class="tag">{{ $item->type_label }}</span><strong>{{ $item->title }}</strong><time>{{ optional($item->published_at)->format('d M Y') }}</time><i>↗</i></a>@empty<div class="news-placeholder"><span class="tag">Project update</span><strong>News, events and project activities will appear here.</strong><time>Coming soon</time></div>@endforelse</div>
</section>

<section class="cta-section"><p class="eyebrow">Join the ecosystem</p><h2>Let’s create shared value.<br><em>Together.</em></h2><p>Learn more, contribute to stakeholder activities or explore opportunities for collaboration with VALUEMAP.</p><a class="button button-lime" href="{{ route('contact') }}">Get in touch ↗</a></section>
@endsection
