@extends('layouts.app')
@section('title', 'Contact')
@section('description', 'Contact the ValueMap project coordination team.')
@section('body_class', 'contact-page')
@section('content')
<header class="page-hero compact"><p class="eyebrow">Contact</p><h1>Get in touch with <em>VALUEMAP.</em></h1><p>Would you like to learn more, contribute to stakeholder activities or explore opportunities for collaboration? Contact the VALUEMAP team.</p></header>
<section class="section contact-layout">
    <div class="contact-details"><p class="eyebrow">Project contact</p><div><small>Project Coordinator</small><strong>InnoStars</strong></div><div><small>Coordination Team</small><strong>VALUEMAP Project Coordination Team</strong></div><div><small>Project email</small><strong>Official project address pending</strong></div><p>For general enquiries, partnership opportunities, stakeholder engagement and media requests, use the form.</p></div>
    <form class="contact-form" method="post" action="{{ route('contact.store') }}">@csrf
        @if(session('success'))<div class="form-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="form-error">Please check the highlighted fields.</div>@endif
        <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="field-row"><label>Full name *<input name="name" value="{{ old('name') }}" required>@error('name')<span>{{ $message }}</span>@enderror</label><label>Email address *<input type="email" name="email" value="{{ old('email') }}" required>@error('email')<span>{{ $message }}</span>@enderror</label></div>
        <div class="field-row"><label>Organisation<input name="organisation" value="{{ old('organisation') }}"></label><label>Subject *<input name="subject" value="{{ old('subject') }}" required>@error('subject')<span>{{ $message }}</span>@enderror</label></div>
        <label>Message *<textarea name="message" rows="7" required>{{ old('message') }}</textarea>@error('message')<span>{{ $message }}</span>@enderror</label>
        <label class="check-field consent-field"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>I agree that VALUEMAP may process the information provided to respond to this enquiry. *</span>@error('consent')<span>{{ $message }}</span>@enderror</label>
        <button class="button" type="submit">Send message ↗</button>
    </form>
</section>
@endsection
