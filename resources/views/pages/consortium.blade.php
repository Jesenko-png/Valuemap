@extends('layouts.app')
@section('title', 'Consortium')
@section('description', 'Meet the nine ValueMap partner organisations working across six European countries.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">The consortium</p><h1>9 partners.<br>6 countries.<br><em>One European map.</em></h1><p>ValueMap brings together complementary experience in health data, policy, research, technology, engagement and ecosystem development.</p></header>
<section class="section map-section">
    <div class="consortium-map" data-consortium-map>
        <div class="map-intro"><p class="eyebrow">Partner network</p><h2>Connected across Europe</h2><p>Final institution names, countries, contacts and exact locations will be added from the partner information pack.</p><div class="map-status" data-map-status><span>●</span> Select a numbered node</div></div>
        <svg viewBox="0 0 900 560" role="img" aria-label="Interactive abstract map showing nine partner locations across six European countries">
            <g class="map-grid"><path d="M50 120H850M50 220H850M50 320H850M50 420H850M180 50V510M340 50V510M500 50V510M660 50V510"/></g>
            <g class="map-links"><path d="M180 185L320 115 430 245 590 145 710 220 650 390 470 430 310 365 220 460"/><path d="M320 115L590 145M430 245L650 390M180 185L310 365"/></g>
            @foreach([[180,185],[320,115],[430,245],[590,145],[710,220],[650,390],[470,430],[310,365],[220,460]] as $i=>$point)
                <g class="partner-node" tabindex="0" role="button" data-partner="Partner {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }} — profile pending" aria-label="Show partner {{ $i+1 }} placeholder"><circle cx="{{ $point[0] }}" cy="{{ $point[1] }}" r="25"/><text x="{{ $point[0] }}" y="{{ $point[1]+5 }}">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</text></g>
            @endforeach
        </svg>
    </div>
</section>
<section class="section partners-section"><div class="section-heading heading-row"><div><p class="eyebrow">Partner directory</p><h2>Profiles ready for <em>real content.</em></h2></div><p class="section-note">The structure below matches the requested data fields without inventing organisations or contacts.</p></div><div class="partner-grid">@for($i=1;$i<=9;$i++)<article><div class="partner-logo">P{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</div><span class="tag">Country pending</span><h3>Partner {{ str_pad($i,2,'0',STR_PAD_LEFT) }}</h3><p>Institution description, project role and expertise will be added after partner validation.</p><footer><span>Contact details pending</span><span>↗</span></footer></article>@endfor</div></section>
@endsection
