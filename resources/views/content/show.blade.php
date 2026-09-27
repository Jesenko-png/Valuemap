@extends('layouts.app')
@section('title', $contentItem->title)
@section('description', $contentItem->excerpt ?: 'A public item from the ValueMap project.')
@section('og_type', 'article')
@section('content')
<article class="article-page">
    <header>
        <a class="back-link" href="{{ in_array($contentItem->type, \App\Models\ContentItem::RESULT_TYPES) ? route('results') : route('news') }}">← Back to {{ in_array($contentItem->type, \App\Models\ContentItem::RESULT_TYPES) ? 'results' : 'news & media' }}</a>
        <div class="article-meta">
            <span class="tag">{{ $contentItem->type_label }}</span>
            @if($contentItem->reference_code)
                <span>{{ $contentItem->reference_code }}</span>
            @endif
            @if($contentItem->published_at)
                <time>{{ $contentItem->published_at->format('d F Y') }}</time>
            @endif
        </div>
        <h1>{{ $contentItem->title }}</h1>
        <p>{{ $contentItem->excerpt }}</p>
    </header>
    @if($contentItem->image_path)
        <img class="article-image" src="{{ asset('storage/'.$contentItem->image_path) }}" alt="">
    @endif
    <div class="article-layout">
        <div class="article-body">{!! nl2br(e($contentItem->body)) !!}</div>
        <aside>
            @if($contentItem->partner)
                <div><small>Responsible partner</small><strong>{{ $contentItem->partner }}</strong></div>
            @endif
            <div><small>Status</small><strong>{{ ucfirst($contentItem->status) }}</strong></div>
            @if($contentItem->event_date)
                <div><small>Event date</small><strong>{{ $contentItem->event_date->format('d M Y, H:i') }}</strong></div>
            @endif
            @if($contentItem->location)
                <div><small>Location</small><strong>{{ $contentItem->location }}</strong></div>
            @endif
            @if($contentItem->target_audience)
                <div><small>Target audience</small><strong>{{ $contentItem->target_audience }}</strong></div>
            @endif
            @if($contentItem->registration_url)
                <a class="button" href="{{ $contentItem->registration_url }}" target="_blank" rel="noopener">Register ↗</a>
            @endif
            @if($contentItem->agenda_url)
                <a class="button button-outline" href="{{ $contentItem->agenda_url }}" target="_blank" rel="noopener">View agenda ↗</a>
            @endif
            @if($contentItem->related_resources)
                <div><small>Related resources</small><p>{{ $contentItem->related_resources }}</p></div>
            @endif
            @if($contentItem->file_path)
                <a class="button" href="{{ asset('storage/'.$contentItem->file_path) }}" download>Download document ↓</a>
            @endif
            @if($contentItem->external_url)
                <a class="button button-outline" href="{{ $contentItem->external_url }}" target="_blank" rel="noopener">Open external link ↗</a>
            @endif
        </aside>
    </div>
</article>
@endsection
