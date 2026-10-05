@extends('layouts.app')
@section('title', 'Stakeholders and ecosystem')
@section('description', 'Discover the stakeholder groups VALUEMAP connects to strengthen responsible and sustainable European health data ecosystems.')
@section('body_class', 'stakeholder-page')
@section('content')
<header class="page-hero"><p class="eyebrow">Stakeholders & ecosystem</p><h1>Connecting the <em>health data ecosystem.</em></h1><p>Sustainable health data ecosystems depend on cooperation between organisations with different responsibilities, needs and perspectives.</p></header>

<section class="section ecosystem-intro"><div class="section-heading"><p class="eyebrow">01 / Who we engage</p><h2>Dialogue across health, research, innovation, policy and <em>society.</em></h2><p class="section-intro">VALUEMAP creates opportunities to identify shared priorities and support practical cooperation across six stakeholder groups.</p></div></section>

<section class="section ecosystem-diagram">
    <div class="ecosystem-core"><small>VALUEMAP</small><strong>Shared ecosystem approach</strong><span>Evidence · trust · cooperation</span></div>
    <div class="ecosystem-groups">@foreach(config('valuemap.stakeholders') as $i=>$group)<article class="reveal"><span>{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span><i aria-hidden="true"></i><h2>{{ $group[0] }}</h2><p>{{ $group[1] }}</p></article>@endforeach</div>
</section>

<section class="section shared-approach"><div><p class="eyebrow">02 / A shared ecosystem approach</p><h2>No single organisation can address these challenges <em>alone.</em></h2></div><div class="connection-list">@foreach(['European and regional initiatives','Public and private stakeholders','Healthcare and research organisations','Technology providers and data owners','Policymakers and citizens','Established infrastructures and emerging innovations'] as $connection)<div><span aria-hidden="true">●</span>{{ $connection }}</div>@endforeach</div></section>

<section class="engagement-band"><div><p class="eyebrow">Targeted engagement</p><h2>An active ecosystem,<br><em>not an audience.</em></h2></div><div><p>Roundtables, workshops and project events will bring stakeholders together to challenge evidence, share needs and shape practical outputs. The goal is an ecosystem in which value is created responsibly and shared fairly.</p><a class="button button-lime" href="{{ route('news') }}?type=event">See project events ↗</a></div></section>
@endsection
