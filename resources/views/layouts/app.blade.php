<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'VALUEMAP connects European health data ecosystems to develop sustainable business models and coordinated action for responsible secondary use of health data.')">
    <meta name="theme-color" content="#0c2537">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'Mapping health data ecosystems across Europe') — ValueMap</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Mapping value. Connecting Europe.') — ValueMap">
    <meta property="og:description" content="@yield('description', 'European health data ecosystems, connected for public value.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(request()->routeIs('content.show') && isset($contentItem) && $contentItem->image_path)
        <meta property="og:image" content="{{ rtrim(config('app.url'), '/') }}/storage/{{ $contentItem->image_path }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ rtrim(config('app.url'), '/') }}/storage/{{ $contentItem->image_path }}">
    @elseif(!request()->routeIs('content.show'))
        <meta property="og:image" content="{{ rtrim(config('app.url'), '/') }}/og.webp">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ rtrim(config('app.url'), '/') }}/og.webp">
    @endif
    <meta name="twitter:title" content="@yield('title', 'Mapping value. Connecting Europe.') — ValueMap">
    <meta name="twitter:description" content="@yield('description', 'European health data ecosystems, connected for public value.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(config('services.analytics.id'))
        <script>window.valueMapAnalyticsId = @json(config('services.analytics.id'));</script>
    @endif
</head>
<body class="@yield('body_class')">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="ValueMap home">
            <img class="site-logo" src="{{ asset('images/brand/valuemap-logo.webp') }}" alt="VALUEMAP" width="725" height="130" decoding="async">
        </a>
        <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="main-navigation" data-menu-toggle><span></span><span></span></button>
        <nav class="site-nav" id="main-navigation" aria-label="Main navigation" data-menu>
            <a @class(['active' => request()->routeIs('home')]) href="{{ route('home') }}">Home</a>
            <a @class(['active' => request()->routeIs('about')]) href="{{ route('about') }}">About</a>
            <a @class(['active' => request()->routeIs('impact')]) href="{{ route('impact') }}">Impact</a>
            <a @class(['active' => request()->routeIs('structure')]) href="{{ route('structure') }}">Project Structure</a>
            <a @class(['active' => request()->routeIs('consortium')]) href="{{ route('consortium') }}">Consortium</a>
            <a @class(['active' => request()->routeIs('ecosystem')]) href="{{ route('ecosystem') }}">Stakeholders</a>
            <a @class(['active' => request()->routeIs('results', 'content.show')]) href="{{ route('results') }}">Results & Resources</a>
            <a @class(['active' => request()->routeIs('news')]) href="{{ route('news') }}">News & Media</a>
            <a class="nav-cta" href="{{ route('contact') }}">Contact <span aria-hidden="true">↗</span></a>
            @auth
                <a class="nav-login" href="{{ auth()->user()->canManageContent() ? route('admin.index') : route('account.index') }}">{{ auth()->user()->canManageContent() ? 'Dashboard' : 'Account' }}</a>
            @else
                <a class="nav-login" href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
    </header>

    <main id="main">@yield('content')</main>

    <footer class="site-footer">
        <div class="footer-main">
            <div>
                <a class="brand footer-brand" href="{{ route('home') }}" aria-label="ValueMap home"><img class="footer-logo" src="{{ asset('images/brand/valuemap-logo.webp') }}" alt="VALUEMAP" width="725" height="130" loading="lazy" decoding="async"></a>
                <p>Supporting fair, ethical and sustainable value-sharing across connected European health data ecosystems.</p>
            </div>
            <div class="footer-links"><h2>Explore</h2><a href="{{ route('about') }}">About VALUEMAP</a><a href="{{ route('impact') }}">Project impact</a><a href="{{ route('structure') }}">Work packages</a><a href="{{ route('consortium') }}">Consortium</a><a href="{{ route('ecosystem') }}">Stakeholders</a></div>
            <div class="footer-links"><h2>Follow the work</h2><a href="{{ route('results') }}">Results & Resources</a><a href="{{ route('news') }}?type=event">Events</a><a href="{{ route('news') }}?type=newsletter">Newsletters</a><a href="{{ config('valuemap.linkedin') }}" target="_blank" rel="noopener">LinkedIn ↗</a><a href="{{ route('contact') }}">Contact</a></div>
            <div class="funding-block">
                <div class="eu-funded-logo"><img src="{{ asset('eu-funding-reference.webp') }}" alt="Funded by the European Union" loading="lazy" decoding="async"></div>
                <p><strong>VALUEMAP has received funding from the European Union under the Horizon Europe programme. Grant Agreement No. {{ config('valuemap.grant_agreement') }}.</strong></p>
                <p>Funded by the European Union. Views and opinions expressed are, however, those of the author(s) only and do not necessarily reflect those of the European Union or the granting authority. Neither the European Union nor the granting authority can be held responsible for them.</p>
            </div>
        </div>
        <div class="footer-bottom"><span>© {{ date('Y') }} VALUEMAP project</span><span>Horizon Europe · Grant Agreement No. {{ config('valuemap.grant_agreement') }}</span><nav aria-label="Legal"><a href="{{ route('privacy') }}">Privacy</a><a href="{{ route('cookies') }}">Cookies</a><a href="{{ route('accessibility') }}">Accessibility</a><a href="{{ route('login') }}">Project login</a></nav></div>
    </footer>
    @if(config('services.analytics.id'))
        <aside class="consent-banner" data-consent-banner hidden aria-label="Analytics preferences">
            <p><strong>Help us improve ValueMap</strong><span>We use optional analytics to understand which project resources are useful. No analytics loads before your choice.</span></p>
            <div><button class="button button-outline" type="button" data-consent="denied">Decline</button><button class="button" type="button" data-consent="granted">Allow analytics</button></div>
        </aside>
    @endif
</body>
</html>
