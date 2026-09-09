@extends('layouts.app')

@section('title', 'Mapping value. Connecting Europe.')
@section('body_class', 'home-page')

@section('content')
<section class="hero">
    <div class="hero-grid">
        <div class="hero-copy reveal">
            <p class="eyebrow"><span></span> Horizon Europe research project</p>
            <h1>Mapping value.<br><em>Connecting</em> Europe.</h1>
            <p class="hero-lede">ValueMap connects regions, data and people to shape a more trusted, useful and inclusive European health data ecosystem.</p>
            <div class="hero-actions"><a class="button" href="{{ route('about') }}">Explore the project <span>↗</span></a><a class="text-link" href="{{ route('results') }}">View public results <span>↓</span></a></div>
        </div>
        <div class="ecosystem-map reveal" aria-label="Abstract map of connected European health data ecosystems">
            <p class="map-label"><span>ECOSYSTEM MAP</span><strong>6 countries · 9 partners</strong></p>
            <svg viewBox="0 0 620 620" role="img" aria-hidden="true"><g class="orbit-lines" fill="none"><ellipse cx="310" cy="310" rx="250" ry="142" transform="rotate(-18 310 310)"/><ellipse cx="310" cy="310" rx="180" ry="272" transform="rotate(37 310 310)"/><circle cx="310" cy="310" r="205"/></g><g class="connections" fill="none"><path d="M124 218C215 160 245 180 310 280S430 390 500 340"/><path d="M178 430C235 360 225 300 310 280S415 190 470 162"/><path d="M136 300C228 320 340 350 452 446"/><path d="M250 112C300 210 350 244 482 260"/></g><g class="nodes"><circle cx="124" cy="218" r="7"/><circle cx="178" cy="430" r="7"/><circle cx="136" cy="300" r="7"/><circle cx="250" cy="112" r="7"/><circle class="node-main" cx="310" cy="280" r="13"/><circle cx="470" cy="162" r="7"/><circle cx="482" cy="260" r="7"/><circle cx="500" cy="340" r="7"/><circle cx="452" cy="446" r="7"/></g></svg>
            <div class="map-chip chip-one"><i></i> Health data</div><div class="map-chip chip-two"><i></i> Shared value</div><div class="map-core"><small>EUROPEAN</small><strong>DATA<br>ECOSYSTEM</strong></div>
        </div>
    </div>
    <div class="project-facts"><div><span>01</span><small>Duration</small><strong>36 months</strong></div><div><span>02</span><small>Consortium</small><strong>9 partners</strong></div><div><span>03</span><small>Geography</small><strong>6 countries</strong></div><div><span>04</span><small>Programme</small><strong>Horizon Europe</strong></div></div>
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
