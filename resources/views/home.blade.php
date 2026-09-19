@extends('layouts.app')

@section('title', 'Mapping value. Connecting Europe.')
@section('body_class', 'home-page')

@section('content')
<section class="hero">
    <img class="hero-background" src="{{ asset('images/visuals/valuemap-europe-network.jpg') }}" alt="" width="1942" height="809" fetchpriority="high">
    <div class="hero-shade" aria-hidden="true"></div>
    <div class="hero-pulses" aria-hidden="true">
        <i style="--x:58%;--y:35%;--delay:.2s;--size:7px"></i>
        <i style="--x:66%;--y:31%;--delay:1.1s;--size:6px"></i>
        <i style="--x:72%;--y:42%;--delay:.6s;--size:8px"></i>
        <i style="--x:79%;--y:37%;--delay:1.8s;--size:6px"></i>
        <i style="--x:84%;--y:49%;--delay:.9s;--size:8px"></i>
        <i style="--x:63%;--y:52%;--delay:1.5s;--size:7px"></i>
        <i style="--x:73%;--y:58%;--delay:.35s;--size:6px"></i>
        <i style="--x:88%;--y:61%;--delay:2.2s;--size:7px"></i>
        <i style="--x:54%;--y:48%;--delay:2.6s;--size:6px"></i>
    </div>
    <div class="hero-grid">
        <div class="hero-copy reveal">
            <p class="eyebrow"><span></span> Horizon Europe research project</p>
            <h1>Mapping value.<br><em>Connecting</em> Europe.</h1>
            <p class="hero-lede">ValueMap connects regions, data and people to shape a more trusted, useful and inclusive European health data ecosystem.</p>
            <div class="hero-actions"><a class="button" href="{{ route('about') }}">Explore the project <span>↗</span></a><a class="text-link" href="{{ route('results') }}">View public results <span>↓</span></a></div>
        </div>
        <div class="hero-insight reveal" aria-label="ValueMap project scope">
            <div class="hero-insight-head"><span>Project scope</span><i aria-hidden="true"></i></div>
            <p>Connecting regional intelligence into one European view.</p>
            <div class="hero-insight-grid"><span><small>Partners</small><strong>09</strong></span><span><small>Countries</small><strong>06</strong></span><span><small>Focus</small><strong>Health data</strong></span></div>
            <a href="{{ route('consortium') }}">Explore the consortium <span>↗</span></a>
        </div>
    </div>
    <div class="project-facts"><div><span>01</span><small>Duration</small><strong>36 months</strong></div><div><span>02</span><small>Consortium</small><strong>9 partners</strong></div><div><span>03</span><small>Geography</small><strong>6 countries</strong></div><div><span>04</span><small>Programme</small><strong>Horizon Europe</strong></div></div>
</section>

<section class="visual-story" data-story-slider aria-label="ValueMap project story">
    <div class="visual-story-heading reveal">
        <p class="eyebrow">The project in focus</p>
        <h2>See how the ecosystem <em>comes together.</em></h2>
        <p>From understanding regional strengths to bringing stakeholders around the same table and turning evidence into public value.</p>
    </div>
    <div class="story-stage" tabindex="0">
        <article class="story-slide is-active" data-story-slide aria-hidden="false">
            <img src="{{ asset('images/visuals/valuemap-europe-network.jpg') }}" alt="Luminous map of connected European regions" width="1942" height="809">
            <div class="story-slide-shade"></div>
            <div class="story-slide-content"><span>01 / Map</span><h3>Understand the landscape.</h3><p>Reveal the actors, assets and connections shaping health data value across Europe.</p><a href="{{ route('about') }}">Why ValueMap ↗</a></div>
        </article>
        <article class="story-slide" data-story-slide aria-hidden="true">
            <img src="{{ asset('images/visuals/valuemap-collaboration.jpg') }}" alt="Researchers and public-sector partners working together around a map" width="2056" height="765" loading="lazy">
            <div class="story-slide-shade"></div>
            <div class="story-slide-content"><span>02 / Connect</span><h3>Bring perspectives together.</h3><p>Healthcare, policy, research, industry and citizens help test what creates real value.</p><a href="{{ route('ecosystem') }}">Meet the ecosystem ↗</a></div>
        </article>
        <article class="story-slide" data-story-slide aria-hidden="true">
            <img src="{{ asset('images/visuals/valuemap-impact-network.jpg') }}" alt="European health, research and community data streams converging into a shared network" width="2048" height="768" loading="lazy">
            <div class="story-slide-shade"></div>
            <div class="story-slide-content"><span>03 / Create value</span><h3>Turn evidence into impact.</h3><p>Translate mapped knowledge into useful pathways, public results and stronger ecosystems.</p><a href="{{ route('results') }}">Explore the library ↗</a></div>
        </article>
        <div class="story-controls" aria-label="Slideshow controls">
            <div class="story-dots"><button class="is-active" type="button" data-story-dot="0" aria-label="Show slide 1" aria-current="true"></button><button type="button" data-story-dot="1" aria-label="Show slide 2"></button><button type="button" data-story-dot="2" aria-label="Show slide 3"></button></div>
            <div class="story-arrows"><button type="button" data-story-prev aria-label="Previous slide">←</button><button type="button" data-story-next aria-label="Next slide">→</button></div>
        </div>
    </div>
</section>

<section class="section intro-section" id="about">
    <div class="section-heading"><p class="eyebrow">01 / The challenge</p><h2>Health data creates value only when <em>ecosystems connect.</em></h2></div>
    <div class="intro-grid"><div class="large-copy">Across Europe, valuable health data, expertise and infrastructure remain fragmented across regions and sectors.</div><div><p>ValueMap will map how these ecosystems work, identify the conditions that help them create public value, and connect the people who shape them.</p><p>By bringing evidence and stakeholders together, the project supports a more coherent, trustworthy and inclusive European health data landscape.</p><a class="arrow-link" href="{{ route('about') }}">Read about the project <span>↗</span></a></div></div>
</section>

<section class="section dark-section" id="structure">
    <div class="section-heading heading-row"><div><p class="eyebrow">02 / Project structure</p><h2>From mapping to <em>lasting impact.</em></h2></div><a class="button button-light" href="{{ route('structure') }}">Explore all work packages ↗</a></div>
    <div class="wp-preview"><article><span>WP 01</span><h3>Coordination & governance</h3><p>Keep the consortium aligned, rigorous and ready to deliver.</p></article><article><span>WP 02</span><h3>Ecosystem mapping</h3><p>Build a shared view of actors, assets, relationships and regional strengths.</p></article><article><span>WP 03</span><h3>Value pathways</h3><p>Understand how data becomes meaningful health, social and economic value.</p></article><article><span>WP 04+</span><h3>Engagement & impact</h3><p>Co-create, validate and share results with the wider European ecosystem.</p></article></div>
</section>

<section class="section ecosystem-preview">
    <div class="section-heading"><p class="eyebrow">03 / The ecosystem</p><h2>One map. <em>Many perspectives.</em></h2></div>
    <div class="stakeholder-wheel">
        @foreach(['Healthcare providers & data owners','Regulators & public authorities','SMEs, startups & technology','Pharma & industry','Researchers & innovators','Citizens & patient groups'] as $i => $group)
            <a href="{{ route('ecosystem') }}"><span>0{{ $i + 1 }}</span><strong>{{ $group }}</strong><i>↗</i></a>
        @endforeach
    </div>
</section>

<section class="section library-section" id="resources">
    <div class="section-heading heading-row"><div><p class="eyebrow">04 / Public value library</p><h2>Evidence made <em>useful.</em></h2></div><a class="arrow-link" href="{{ route('results') }}">Browse all results <span>↗</span></a></div>
    <div class="content-grid">
        @forelse($latestResults as $item)
            @include('partials.content-card', ['item' => $item])
        @empty
            <article class="empty-card"><span>Library opening soon</span><h3>Public deliverables, publications and project outputs will live here.</h3><p>The first materials are planned for late October.</p><a href="{{ route('results') }}">Visit the library →</a></article>
        @endforelse
    </div>
</section>

<section class="section news-section" id="news">
    <div class="section-heading heading-row"><div><p class="eyebrow">05 / News & media</p><h2>Follow the <em>connections.</em></h2></div><a class="arrow-link" href="{{ route('news') }}">All updates <span>↗</span></a></div>
    <div class="news-list">
        @forelse($latestNews as $item)
            <a href="{{ route('content.show', $item) }}"><span class="tag">{{ $item->type_label }}</span><strong>{{ $item->title }}</strong><time>{{ optional($item->published_at)->format('d M Y') }}</time><i>↗</i></a>
        @empty
            <div class="news-placeholder"><span class="tag">Project update</span><strong>The ValueMap project has started. News and event announcements will appear here.</strong><time>Coming soon</time></div>
        @endforelse
    </div>
</section>

<section class="cta-section"><p class="eyebrow">Join the ecosystem</p><h2>Let’s map what matters.<br><em>Together.</em></h2><p>Are you part of Europe’s health data landscape? Connect with the ValueMap coordination team.</p><a class="button button-lime" href="{{ route('contact') }}">Get in touch ↗</a></section>
@endsection
