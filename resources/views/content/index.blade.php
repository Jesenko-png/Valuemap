@extends('layouts.app')
@php
    $isResults = $section === 'results';
    $labels = ['deliverable'=>'Deliverables','publication'=>'Publications','other_result'=>'Other outputs','news'=>'News','event'=>'Events','newsletter'=>'Newsletters','press'=>'Press / Media'];
@endphp
@section('title', $isResults ? 'Public results library' : 'News and media')
@section('description', $isResults ? 'Browse public ValueMap deliverables, publications and project outputs.' : 'Follow ValueMap news, events, newsletters and media coverage.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">{{ $isResults ? 'Public value library' : 'Communication hub' }}</p><h1>{{ $isResults ? 'Results built to be' : 'Follow the work' }} <em>{{ $isResults ? 'used.' : 'as it happens.' }}</em></h1><p>{{ $isResults ? 'A growing public library of deliverables, publications and practical outputs produced throughout the ValueMap project.' : 'News, events, newsletters and media resources from across the ValueMap consortium.' }}</p></header>
<section class="section listing-section">
    <form class="filter-bar" method="get"><div class="filter-tabs"><a @class(['active'=>!$activeType]) href="{{ url()->current() }}">All</a>@foreach($types as $type)<a @class(['active'=>$activeType===$type]) href="{{ url()->current() }}?type={{ $type }}">{{ $labels[$type] }}</a>@endforeach</div><label class="search-field"><span class="sr-only">Search</span><input type="search" name="q" value="{{ $search }}" placeholder="Search the library"><button type="submit">Search</button></label></form>
    <div class="content-grid listing-grid">
        @forelse($items as $item) @include('partials.content-card', ['item'=>$item])
        @empty <div class="empty-state"><span>Nothing published yet</span><h2>{{ $isResults ? 'The library is ready for the first public result.' : 'Project updates will appear here as they are published.' }}</h2><p>Try another filter or return soon.</p></div>
        @endforelse
    </div>
    <div class="pagination">{{ $items->links() }}</div>
</section>
@endsection
