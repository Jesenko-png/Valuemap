@extends('layouts.app')
@php
    $isResults = $section === 'results';
    $labels = ['deliverable'=>'Deliverables','publication'=>'Publications','communication_material'=>'Communication materials','event_material'=>'Event materials','other_result'=>'Other outputs','news'=>'News','event'=>'Events','newsletter'=>'Newsletters','press'=>'Press / Media'];
@endphp
@section('title', $isResults ? 'Public results library' : 'News and media')
@section('description', $isResults ? 'Browse public ValueMap deliverables, publications and project outputs.' : 'Follow ValueMap news, events, newsletters and media coverage.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">{{ $isResults ? 'Results & Resources' : 'News & Media' }}</p><h1>{{ $isResults ? 'From project work to' : 'Follow VALUEMAP' }} <em>{{ $isResults ? 'practical resources.' : 'as it happens.' }}</em></h1><p>{{ $isResults ? 'An organised public collection of reports, recommendations, tools and materials supporting research, cooperation and implementation.' : 'Stay informed about project activities, stakeholder engagement, upcoming opportunities and new resources.' }}</p></header>
<section class="section listing-section">
    <form class="filter-bar" method="get"><div class="filter-tabs"><a @class(['active'=>!$activeType]) href="{{ url()->current() }}">All</a>@foreach($types as $type)<a @class(['active'=>$activeType===$type]) href="{{ url()->current() }}?type={{ $type }}">{{ $labels[$type] }}</a>@endforeach</div><label class="search-field"><span class="sr-only">Search</span><input type="search" name="q" value="{{ $search }}" placeholder="Search the library"><button type="submit">Search</button></label></form>
    @if($activeType === 'event')<nav class="period-tabs" aria-label="Filter events by date"><a @class(['active'=>!$eventPeriod]) href="{{ route('news',['type'=>'event']) }}">All events</a><a @class(['active'=>$eventPeriod==='upcoming']) href="{{ route('news',['type'=>'event','period'=>'upcoming']) }}">Upcoming</a><a @class(['active'=>$eventPeriod==='past']) href="{{ route('news',['type'=>'event','period'=>'past']) }}">Past</a></nav>@endif
    <div class="content-grid listing-grid">
        @forelse($items as $item) @include('partials.content-card', ['item'=>$item])
        @empty <div class="empty-state"><span>Nothing published yet</span><h2>{{ $isResults ? 'The library is ready for the first public result.' : 'Project updates will appear here as they are published.' }}</h2><p>Try another filter or return soon.</p></div>
        @endforelse
    </div>
    <div class="pagination">{{ $items->links() }}</div>
</section>
@unless($isResults)
<section class="newsletter-cta"><div><p class="eyebrow">Stay connected</p><h2>Follow new findings, events and resources.</h2><p>Subscribe to receive project updates, key findings, upcoming events and new resources.</p></div><form class="newsletter-form" method="post" action="{{ route('newsletter.subscribe') }}">@csrf<div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>@if(session('newsletter_success'))<div class="form-success">{{ session('newsletter_success') }}</div>@endif<label><span>Email address</span><input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.org">@error('email','newsletter')<small>{{ $message }}</small>@enderror</label><label class="newsletter-consent"><input type="checkbox" name="consent" value="1" required><span>I agree to receive VALUEMAP project updates and understand I can unsubscribe at any time.</span></label>@error('consent','newsletter')<small>{{ $message }}</small>@enderror<button class="button button-lime" type="submit">Subscribe →</button><a href="{{ config('valuemap.linkedin') }}" target="_blank" rel="noopener">Or follow VALUEMAP on LinkedIn ↗</a></form></section>
@endunless
@endsection
