@extends('layouts.app')
@section('title', 'Project structure')
@section('description', 'Explore the ValueMap work packages, activities, responsibilities, outputs and implementation timeline.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">Project structure</p><h1>Six connected streams.<br><em>One shared direction.</em></h1><p>The work-package framework below is a design-ready draft. Final titles, leads, outputs and dates will be inserted after consortium confirmation.</p></header>
<section class="section wp-list">
@php
$wps = [
 ['01','Project coordination & governance','A coherent, ethical and high-performing project.',['Scientific and administrative coordination','Quality, ethics and risk management','Consortium governance'],'Coordinator / lead to be confirmed','Management framework, quality and data plans','M01–M36'],
 ['02','European ecosystem mapping','A comparable picture of participating health data ecosystems.',['Mapping actors and resources','Regional evidence collection','Cross-country comparison'],'Lead partner to be confirmed','Ecosystem maps and comparative evidence base','M01–M18'],
 ['03','Value creation pathways','Understand how data, capabilities and relationships create public value.',['Value pathway analysis','Barrier and enabler assessment','Framework development'],'Lead partner to be confirmed','Value creation framework and assessment tools','M07–M24'],
 ['04','Stakeholder co-creation','Validate insights with the people who govern, provide, use and are represented in health data.',['Targeted roundtables','Co-creation workshops','Citizen and patient engagement'],'Lead partner to be confirmed','Validated needs, scenarios and recommendations','M07–M30'],
 ['05','Piloting & transferability','Turn evidence into practical models that regions can apply.',['Regional validation','Transferability assessment','Practical guidance'],'Lead partner to be confirmed','Regional roadmaps and replication guidance','M13–M34'],
 ['06','Communication, dissemination & impact','Make project knowledge visible, accessible and useful during and after ValueMap.',['Communication and media','Scientific dissemination','Exploitation and sustainability'],'Lead partner to be confirmed','Public library, events, publications and impact plan','M01–M36'],
];
@endphp
@foreach($wps as $wp)
<article class="wp-row reveal"><div class="wp-id"><span>WP</span><strong>{{ $wp[0] }}</strong><small>{{ $wp[6] }}</small></div><div class="wp-summary"><p class="tag">Provisional working title</p><h2>{{ $wp[1] }}</h2><p>{{ $wp[2] }}</p></div><div class="wp-details"><div><h3>Main activities</h3><ul>@foreach($wp[3] as $activity)<li>{{ $activity }}</li>@endforeach</ul></div><div><h3>Responsible partner</h3><p>{{ $wp[4] }}</p><h3>Key outputs</h3><p>{{ $wp[5] }}</p></div></div></article>
@endforeach
</section>
@endsection
