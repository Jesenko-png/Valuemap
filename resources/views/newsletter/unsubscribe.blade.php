@extends('layouts.app')
@section('title', 'Unsubscribe from VALUEMAP')
@section('description', 'Manage your VALUEMAP newsletter subscription.')
@section('content')
<header class="page-hero compact newsletter-status"><p class="eyebrow">Newsletter</p><h1>Unsubscribe?</h1><p>Confirm that {{ $subscriber->email }} should stop receiving VALUEMAP newsletter messages.</p>
<form method="post" action="{{ URL::signedRoute('newsletter.unsubscribe.store', ['subscriber' => $subscriber]) }}">@csrf<button class="button button-light" type="submit">Confirm unsubscribe</button></form></header>
<section class="section"><a class="arrow-link" href="{{ route('news') }}">Keep subscription and return <span>↗</span></a></section>
@endsection
