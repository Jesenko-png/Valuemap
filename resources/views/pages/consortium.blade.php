@extends('layouts.app')
@section('title', 'Consortium')
@section('description', 'Meet the nine VALUEMAP organisations connecting health, research, public administration, innovation and industry across six countries.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">The consortium</p><h1>Connecting expertise <em>across Europe.</em></h1><p>Nine organisations from six countries combine expertise in healthcare, research, digital health, public administration, innovation, industry and health data governance.</p></header>

<section class="section map-section">
    @php
        $mapBounds = ['minLongitude' => -25, 'maxLongitude' => 45, 'minLatitude' => 34, 'maxLatitude' => 72];
        $projectPoint = function (float $longitude, float $latitude) use ($mapBounds): array {
            $x = 40 + (($longitude - $mapBounds['minLongitude']) / ($mapBounds['maxLongitude'] - $mapBounds['minLongitude'])) * 820;
            $y = 30 + (($mapBounds['maxLatitude'] - $latitude) / ($mapBounds['maxLatitude'] - $mapBounds['minLatitude'])) * 560;
            return [round($x, 1), round($y, 1)];
        };
        $countryCodes = ['Hungary' => 'HUN', 'Spain' => 'ESP', 'Portugal' => 'PRT', 'Sweden' => 'SWE', 'Bosnia and Herzegovina' => 'BIH', 'Ireland' => 'IRL'];
        $partnerPoints = collect(config('valuemap.partners'))->map(function ($partner, $index) use ($projectPoint, $countryCodes) {
            [$x, $y] = $projectPoint($partner['longitude'], $partner['latitude']);
            $x += $partner['map_offset_x'] ?? 0;
            $y += $partner['map_offset_y'] ?? 0;
            return [...$partner, 'number' => $index + 1, 'x' => $x, 'y' => $y, 'country_code' => $countryCodes[$partner['country']]];
        });
        $coordinator = $partnerPoints->first();
        $countryGroups = $partnerPoints->groupBy('country');
    @endphp
    <div class="consortium-map" data-consortium-map>
        <div class="map-intro">
            <p class="eyebrow">European network</p>
            <h2>Six countries.<br>One shared effort.</h2>
            <p>Seven beneficiaries, one affiliated partner and one associated partner bring complementary regional and sectoral perspectives.</p>
            <ul class="map-country-list" aria-label="Partner countries">
                @foreach($countryGroups as $country => $partners)
                    <li><span>{{ $countryCodes[$country] }}</span><strong>{{ $country }}</strong><small>{{ $partners->count() }} {{ Str::plural('partner', $partners->count()) }}</small></li>
                @endforeach
            </ul>
            <div class="map-status" data-map-status aria-live="polite"><span aria-hidden="true">●</span><div><strong data-map-status-title>Explore partner locations</strong><small data-map-status-meta>Select a numbered marker on the map.</small></div></div>
        </div>
        <div class="europe-map-panel">
            <svg viewBox="0 0 900 620" role="img" aria-labelledby="europe-map-title europe-map-description">
                <title id="europe-map-title">Map of the VALUEMAP consortium across Europe</title>
                <desc id="europe-map-description">A geographic map showing nine partner locations in Hungary, Spain, Portugal, Sweden, Bosnia and Herzegovina, and Ireland.</desc>
                <defs>
                    <radialGradient id="map-glow"><stop offset="0" stop-color="#80e9dc" stop-opacity=".22"/><stop offset="1" stop-color="#80e9dc" stop-opacity="0"/></radialGradient>
                    <filter id="pin-shadow" x="-80%" y="-80%" width="260%" height="260%"><feDropShadow dx="0" dy="4" stdDeviation="5" flood-color="#071f1f" flood-opacity=".32"/></filter>
                </defs>
                <circle class="map-glow" cx="520" cy="330" r="330" fill="url(#map-glow)"/>
                @include('partials.europe-map')
                <g class="map-network-lines" aria-hidden="true">
                    @foreach($partnerPoints->skip(1) as $point)
                        <path d="M{{ $coordinator['x'] }} {{ $coordinator['y'] }} L{{ $point['x'] }} {{ $point['y'] }}"/>
                    @endforeach
                </g>
                <g class="partner-pins">
                    @foreach($partnerPoints as $partner)
                        @php($locationLabel = $partner['location'] === $partner['country'] ? $partner['country'] : $partner['location'].' · '.$partner['country'])
                        <g class="partner-node" tabindex="0" role="button" data-partner="{{ $partner['name'] }}" data-location="{{ $locationLabel }}" data-country-code="{{ $partner['country_code'] }}" aria-label="Show {{ $partner['name'] }}, {{ $locationLabel }}">
                            <circle class="partner-node-pulse" cx="{{ $partner['x'] }}" cy="{{ $partner['y'] }}" r="25"/>
                            <circle class="partner-node-dot" cx="{{ $partner['x'] }}" cy="{{ $partner['y'] }}" r="17" filter="url(#pin-shadow)"/>
                            <text x="{{ $partner['x'] }}" y="{{ $partner['y'] + 4 }}">{{ str_pad($partner['number'], 2, '0', STR_PAD_LEFT) }}</text>
                        </g>
                    @endforeach
                </g>
            </svg>
            <p class="map-attribution">Geographic boundaries: Natural Earth · Public domain</p>
        </div>
    </div>
</section>

<section class="section partners-section"><div class="section-heading heading-row"><div><p class="eyebrow">Partner directory</p><h2>Nine organisations.<br><em>Complementary expertise.</em></h2></div><p class="section-note">Official organisation links open in a new tab. Partner contact persons can be added when the consortium approves them for publication.</p></div><div class="partner-grid">@foreach(config('valuemap.partners') as $partner)<article class="reveal"><div class="partner-logo" aria-hidden="true">{{ $partner['initials'] }}</div><span class="tag">{{ $partner['country'] }}</span><h3>{{ $partner['name'] }}</h3><strong class="partner-role">{{ $partner['role'] }}</strong><p>{{ $partner['description'] }}</p><footer><a href="{{ $partner['url'] }}" target="_blank" rel="noopener">Official website</a><span>↗</span></footer></article>@endforeach</div></section>

<section class="cta-section"><p class="eyebrow">Wider ecosystem</p><h2>Expertise grows through<br><em>stakeholder cooperation.</em></h2><p>See the communities VALUEMAP engages across healthcare, policy, research, innovation, industry and society.</p><a class="button button-lime" href="{{ route('ecosystem') }}">Explore the ecosystem ↗</a></section>
@endsection
