<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ValueMap connects Europe's health data ecosystems to turn fragmented knowledge into shared public value.">
    <title>ValueMap — Mapping health data ecosystems across Europe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="ValueMap home">
            <span class="brand-mark" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
            <span><strong>VALUE</strong>MAP<small>European health data ecosystems</small></span>
        </a>
        <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false" data-menu-toggle><span></span><span></span></button>
        <nav class="site-nav" aria-label="Main navigation" data-menu>
            <a class="active" href="{{ route('home') }}">Home</a>
            <a href="#about">About</a><a href="#structure">Structure</a><a href="#consortium">Consortium</a>
            <a href="#resources">Results</a><a href="#news">News & media</a>
            <a class="nav-cta" href="#contact">Contact <span aria-hidden="true">↗</span></a>
        </nav>
    </header>

    <main id="main">
        <section class="hero">
            <div class="hero-grid">
                <div class="hero-copy">
                    <p class="eyebrow"><span></span> Horizon Europe research project</p>
                    <h1>Mapping value.<br><em>Connecting</em> Europe.</h1>
                    <p class="hero-lede">ValueMap connects regions, data and people to shape a more trusted, useful and inclusive European health data ecosystem.</p>
                    <div class="hero-actions">
                        <a class="button" href="#about">Explore the project <span>↗</span></a>
                        <a class="text-link" href="#resources">View public results <span>↓</span></a>
                    </div>
                </div>

                <div class="ecosystem-map" aria-label="Abstract map of connected European health data ecosystems">
                    <p class="map-label"><span>LIVE MAP</span><strong>6 countries · 9 partners</strong></p>
                    <svg viewBox="0 0 620 620" role="img" aria-hidden="true">
                        <g class="orbit-lines" fill="none"><ellipse cx="310" cy="310" rx="250" ry="142" transform="rotate(-18 310 310)"/><ellipse cx="310" cy="310" rx="180" ry="272" transform="rotate(37 310 310)"/><circle cx="310" cy="310" r="205"/></g>
                        <g class="connections" fill="none"><path d="M124 218C215 160 245 180 310 280S430 390 500 340"/><path d="M178 430C235 360 225 300 310 280S415 190 470 162"/><path d="M136 300C228 320 340 350 452 446"/><path d="M250 112C300 210 350 244 482 260"/></g>
                        <g class="nodes"><circle cx="124" cy="218" r="7"/><circle cx="178" cy="430" r="7"/><circle cx="136" cy="300" r="7"/><circle cx="250" cy="112" r="7"/><circle class="node-main" cx="310" cy="280" r="13"/><circle cx="470" cy="162" r="7"/><circle cx="482" cy="260" r="7"/><circle cx="500" cy="340" r="7"/><circle cx="452" cy="446" r="7"/></g>
                    </svg>
                    <div class="map-chip chip-one"><i></i> Health data</div><div class="map-chip chip-two"><i></i> Shared value</div>
                    <div class="map-core"><small>EUROPEAN</small><strong>DATA<br>ECOSYSTEM</strong></div>
                </div>
            </div>

            <div class="project-facts" aria-label="Project facts">
                <div><span>01</span><small>Duration</small><strong>36 months</strong></div><div><span>02</span><small>Consortium</small><strong>9 partners</strong></div>
                <div><span>03</span><small>Geography</small><strong>6 countries</strong></div><div><span>04</span><small>Programme</small><strong>Horizon Europe</strong></div>
            </div>
        </section>
    </main>
</body>
</html>
