@extends('layouts.app')
@section('title', 'Consortium')
@section('description', 'Meet the nine VALUEMAP organisations connecting health, research, public administration, innovation and industry across six countries.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">The consortium</p><h1>Connecting expertise <em>across Europe.</em></h1><p>Nine organisations from six countries combine expertise in healthcare, research, digital health, public administration, innovation, industry and health data governance.</p></header>

<section class="section map-section">
    <div class="consortium-map" data-consortium-map>
        <div class="map-intro"><p class="eyebrow">European network</p><h2>Six countries.<br>One shared effort.</h2><p>Seven beneficiaries, one affiliated partner and one associated partner bring complementary regional and sectoral perspectives.</p><div class="map-status" data-map-status><span>●</span> Select a numbered node</div></div>
        @php($points = [[480,150],[360,390],[275,360],[485,75],[355,430],[580,420],[395,410],[430,445],[165,250]])
        <svg viewBox="0 0 900 560" role="img" aria-label="Interactive network map showing nine VALUEMAP partner organisations">
            <g class="map-grid"><path d="M50 120H850M50 220H850M50 320H850M50 420H850M180 50V510M340 50V510M500 50V510M660 50V510"/></g>
            <g class="map-links"><path d="M480 150L360 390 275 360 485 75 355 430 580 420 395 410 430 445 165 250"/><path d="M480 150L485 75M360 390L580 420M275 360L165 250"/></g>
            @foreach(config('valuemap.partners') as $i=>$partner)
                <g class="partner-node" tabindex="0" role="button" data-partner="{{ $partner['name'] }} — {{ $partner['country'] }}" aria-label="Show {{ $partner['name'] }}"><circle cx="{{ $points[$i][0] }}" cy="{{ $points[$i][1] }}" r="25"/><text x="{{ $points[$i][0] }}" y="{{ $points[$i][1]+5 }}">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</text></g>
            @endforeach
        </svg>
    </div>
</section>

<section class="section partners-section"><div class="section-heading heading-row"><div><p class="eyebrow">Partner directory</p><h2>Nine organisations.<br><em>Complementary expertise.</em></h2></div><p class="section-note">Official organisation links open in a new tab. Partner contact persons can be added when the consortium approves them for publication.</p></div><div class="partner-grid">@foreach(config('valuemap.partners') as $partner)<article class="reveal"><div class="partner-logo" aria-hidden="true">{{ $partner['initials'] }}</div><span class="tag">{{ $partner['country'] }}</span><h3>{{ $partner['name'] }}</h3><strong class="partner-role">{{ $partner['role'] }}</strong><p>{{ $partner['description'] }}</p><footer><a href="{{ $partner['url'] }}" target="_blank" rel="noopener">Official website</a><span>↗</span></footer></article>@endforeach</div></section>

<section class="cta-section"><p class="eyebrow">Wider ecosystem</p><h2>Expertise grows through<br><em>stakeholder cooperation.</em></h2><p>See the communities VALUEMAP engages across healthcare, policy, research, innovation, industry and society.</p><a class="button button-lime" href="{{ route('ecosystem') }}">Explore the ecosystem ↗</a></section>
@endsection
