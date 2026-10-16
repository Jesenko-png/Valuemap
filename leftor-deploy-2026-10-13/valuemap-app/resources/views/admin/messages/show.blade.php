@extends('layouts.admin')
@section('title', 'Contact message')
@section('content')
<div class="admin-title"><div><a class="back-link" href="{{ route('admin.messages.index') }}">← Contact messages</a><h1>{{ $message->subject }}</h1></div></div>
<section class="admin-form inbox-message">
    <dl class="inbox-details">
        <div><dt>From</dt><dd>{{ $message->name }}</dd></div>
        <div><dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd></div>
        <div><dt>Organisation</dt><dd>{{ $message->organisation ?: '—' }}</dd></div>
        <div><dt>Received</dt><dd>{{ $message->created_at->format('d M Y, H:i') }}</dd></div>
        <div><dt>Consent recorded</dt><dd>{{ $message->consent_at?->format('d M Y, H:i') ?: 'Not recorded' }}</dd></div>
    </dl>
    <h2>Message</h2><div class="inbox-body">{{ $message->message }}</div>
    <p><a class="button" href="mailto:{{ $message->email }}">Open email app to reply ↗</a></p>
</section>
@endsection
