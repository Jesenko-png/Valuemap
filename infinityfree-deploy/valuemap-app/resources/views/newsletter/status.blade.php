@extends('layouts.app')
@section('title', $title)
@section('description', 'VALUEMAP newsletter subscription status.')
@section('content')
<header class="page-hero compact newsletter-status"><p class="eyebrow">Newsletter</p><h1>{{ $title }}</h1><p>{{ $message }}</p>@if($subscriber)<a class="button button-light" href="{{ URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $subscriber]) }}">Unsubscribe</a>@endif</header>
<section class="section"><a class="arrow-link" href="{{ route('news') }}">Return to News & Media <span>↗</span></a></section>
@endsection
