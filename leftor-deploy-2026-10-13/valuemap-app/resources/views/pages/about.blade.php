@extends('layouts.app')
@section('title', 'About VALUEMAP')
@section('description', 'Learn how VALUEMAP supports fair, ethical and sustainable value-sharing through connected European health data ecosystems.')
@section('body_class', 'about-page')
@section('content')
<header class="page-hero"><p class="eyebrow">About VALUEMAP</p><h1>Creating the conditions for <em>shared value</em> from health data.</h1><p>VALUEMAP examines how health data business models can support responsible and sustainable secondary use across Europe.</p></header>

<section class="section split-feature"><div><p class="eyebrow">01 / Project context</p><h2>A strategic resource.<br><em>A shared responsibility.</em></h2></div><div class="prose"><p>When responsibly accessed and effectively used, health data can support scientific research, improve healthcare delivery, strengthen public health planning and enable innovative technologies and services.</p><p>Yet health data ecosystems remain fragmented. Stakeholders face different regulatory, organisational, technical and financial conditions, making cooperation and sustainable value creation difficult.</p></div></section>

<section class="section secondary-use-section"><div class="section-heading"><p class="eyebrow">02 / Secondary use of health data</p><h2>Data supporting knowledge, policy and <em>innovation.</em></h2><p class="section-intro">Secondary use means using data originally collected for healthcare or other purposes to support broader public-interest activities.</p></div><div class="use-case-grid">@foreach(['Scientific research','Innovation and product development','Public health monitoring','Health policy and planning','Education and training','Regulatory and societal analysis'] as $i=>$case)<article class="reveal"><span>0{{ $i+1 }}</span><h3>{{ $case }}</h3></article>@endforeach</div></section>

<section class="section challenge-grid-section"><div class="section-heading"><p class="eyebrow">03 / The challenge</p><h2>Trusted access needs <em>clear conditions.</em></h2></div><div class="challenge-grid">@foreach(['Who can access data and under which conditions','How access and use should be governed','How costs and benefits can be distributed','How data can be licensed and reused','How different stakeholders can participate','How initiatives remain sustainable over time'] as $question)<div>{{ $question }}</div>@endforeach</div></section>

<section class="section objective-panel"><p class="eyebrow">04 / Project objective</p><div><span class="objective-number">01</span><h2>Support more interconnected, inclusive and efficient European health data ecosystems by identifying, assessing and promoting business models that enable fair, ethical, transparent and sustainable value-sharing.</h2></div></section>

<section class="section phases-section"><div class="section-heading"><p class="eyebrow">05 / From analysis to implementation</p><h2>Two phases. <em>One practical outcome.</em></h2></div><div class="phase-grid"><article><span>Phase 01</span><h3>Understanding and assessing</h3><p>European research and regional assessments through stakeholder engagement, interviews, roundtables and use-case analysis.</p></article><article><span>Phase 02</span><h3>Co-creating and acting</h3><p>Evidence translated into recommendations, shared priorities, a Multi-annual Joint Action Plan and an Implementation Toolkit.</p></article></div></section>

<section class="impact-band"><p class="eyebrow">Explore the difference</p><h2>From shared knowledge to<br><em>coordinated action.</em></h2><a class="button button-lime" href="{{ route('impact') }}">Explore project impact ↗</a></section>
@endsection
