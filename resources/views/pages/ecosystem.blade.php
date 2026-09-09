@extends('layouts.app')
@section('title', 'Stakeholder ecosystem')
@section('description', 'See who ValueMap is for and how different stakeholder groups contribute to European health data ecosystems.')
@section('content')
<header class="page-hero"><p class="eyebrow">Stakeholders / Ecosystem</p><h1>Health data value is <em>collective.</em></h1><p>ValueMap is designed for the people and organisations who provide, govern, develop, research, use and are represented within health data ecosystems.</p></header>
<section class="section ecosystem-diagram">
    <div class="ecosystem-core"><small>ValueMap</small><strong>Shared public value</strong><span>Evidence · trust · collaboration</span></div>
    <div class="ecosystem-groups">
        @foreach([
            ['Healthcare providers & data owners','Clinical realities, data stewardship and implementation insight.'],
            ['Regulators & public authorities','Governance, safeguards and the public-policy perspective.'],
            ['SMEs, startups & technology','Tools, innovation capacity and routes to practical deployment.'],
            ['Pharma & industry','Research, development and cross-sector value pathways.'],
            ['Researchers & innovators','Methods, evidence, evaluation and scientific exchange.'],
            ['Citizens & patient groups','Lived experience, legitimacy, trust and public-interest priorities.'],
        ] as $i=>$group)
        <article><span>0{{ $i+1 }}</span><h2>{{ $group[0] }}</h2><p>{{ $group[1] }}</p></article>
        @endforeach
    </div>
</section>
<section class="engagement-band"><div><p class="eyebrow">Targeted engagement</p><h2>Not an audience.<br><em>An active ecosystem.</em></h2></div><div><p>Roundtables, workshops and project events will create focused spaces for stakeholders to challenge evidence, share needs and shape outputs.</p><a class="button button-lime" href="{{ route('news') }}?type=event">See project events ↗</a></div></section>
@endsection
