@extends('layouts.app')
@section('title', 'Project impact')
@section('description', 'Explore the reports, recommendations, tools and long-term impact VALUEMAP will deliver for European health data ecosystems.')
@section('content')
<header class="page-hero"><p class="eyebrow">Project impact</p><h1>From shared knowledge to <em>coordinated action.</em></h1><p>VALUEMAP will deliver practical knowledge, recommendations and tools that help stakeholders strengthen sustainable health data ecosystems across Europe.</p></header>

<section class="section results-showcase"><div class="section-heading"><p class="eyebrow">01 / Key results</p><h2>Knowledge designed to be <em>used.</em></h2></div><div class="result-card-grid">@foreach(config('valuemap.results') as $i=>$result)<article class="reveal"><span>0{{ $i+1 }}</span><h3>{{ $result[0] }}</h3><p>{{ $result[1] }}</p><small>Future public resource</small></article>@endforeach</div></section>

<section class="section expected-impact"><div class="section-heading"><p class="eyebrow">02 / Expected impact</p><h2>What difference will <em>VALUEMAP make?</em></h2></div><div class="impact-statement-grid">@foreach([
['Cooperation','Stronger cooperation between European regions.'],
['Understanding','Better understanding of health data business models.'],
['Value-sharing','More transparent and sustainable approaches to value-sharing.'],
['Alignment','Closer alignment between regional and European priorities.'],
['Capacity','Greater stakeholder capacity and participation.'],
['Networks','More effective use of existing initiatives and networks.'],
['Innovation','Improved conditions for data-driven research and innovation.'],
['Inclusion','More inclusive and resilient health data ecosystems.']
] as $i=>$impact)<article><span aria-hidden="true">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span><h3>{{ $impact[0] }}</h3><p>{{ $impact[1] }}</p></article>@endforeach</div></section>

<section class="impact-band"><p class="eyebrow">Public knowledge</p><h2>Reports, tools and resources<br><em>available as the project progresses.</em></h2><a class="button button-lime" href="{{ route('results') }}">Visit Results & Resources ↗</a></section>
@endsection
