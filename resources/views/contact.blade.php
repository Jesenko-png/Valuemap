@extends('layouts.app')
@section('title', 'Contact')
@section('description', 'Contact the ValueMap project coordination team.')
@section('content')
<header class="page-hero compact"><p class="eyebrow">Contact</p><h1>Start a <em>connection.</em></h1><p>Questions about the project, its outputs or upcoming stakeholder activities? Get in touch with the ValueMap coordination team.</p></header>
<section class="section contact-layout">
    <div class="contact-details"><p class="eyebrow">Project contact</p><div><small>Project Coordinator</small><strong>Name and institution pending</strong></div><div><small>Coordination Team</small><strong>Contact details pending</strong></div><div><small>Project email</small><strong>Official address pending</strong></div><p class="draft-note">Final coordinator names and the official project email will be inserted from the approved contact pack.</p></div>
    <form class="contact-form" method="post" action="{{ route('contact.store') }}">@csrf
        @if(session('success'))<div class="form-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="form-error">Please check the highlighted fields.</div>@endif
        <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="field-row"><label>Full name *<input name="name" value="{{ old('name') }}" required>@error('name')<span>{{ $message }}</span>@enderror</label><label>Email address *<input type="email" name="email" value="{{ old('email') }}" required>@error('email')<span>{{ $message }}</span>@enderror</label></div>
        <div class="field-row"><label>Organisation<input name="organisation" value="{{ old('organisation') }}"></label><label>Subject *<input name="subject" value="{{ old('subject') }}" required>@error('subject')<span>{{ $message }}</span>@enderror</label></div>
        <label>Message *<textarea name="message" rows="7" required>{{ old('message') }}</textarea>@error('message')<span>{{ $message }}</span>@enderror</label>
        <button class="button" type="submit">Send message ↗</button>
    </form>
</section>
@endsection
