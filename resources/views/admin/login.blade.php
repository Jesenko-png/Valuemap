<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Login & registration — ValueMap</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="admin-body auth-body">
<main class="auth-shell">
    <section class="auth-intro">
        <a href="{{ route('home') }}"><img class="auth-logo" src="{{ asset('images/brand/valuemap-logo.png') }}" alt="VALUEMAP" width="725" height="130"></a>
        <div><p class="eyebrow">Project workspace</p><h1>One account.<br><em>Clear responsibilities.</em></h1><p>Sign in to follow the project or manage news, events, deliverables and newsletters according to your approved role.</p></div>
        <ul><li><strong>Main administrator</strong><span>Approves accounts and roles, and manages all content.</span></li><li><strong>Administrator</strong><span>Creates, edits and publishes project content.</span></li><li><strong>Reader</strong><span>Uses an approved account without publishing access.</span></li></ul>
    </section>
    <section class="auth-panel">
        <form class="auth-form" method="post" action="{{ route('login.store') }}">
            @csrf
            <p class="eyebrow">Member login</p><h2>Welcome back.</h2><p>Use your approved ValueMap account.</p>
            @if(session('registration_success'))<div class="form-success">{{ session('registration_success') }}</div>@endif
            @if(session('error'))<div class="form-error">{{ session('error') }}</div>@endif
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
            <label>Email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus></label>
            <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
            <label class="check-field"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="button" type="submit">Sign in →</button>
        </form>

        <details class="register-expand" @if($errors->register->any()) open @endif>
            <summary><span><small>New to ValueMap?</small><strong>Request an account</strong></span><i>+</i></summary>
            <form class="auth-form register-form" method="post" action="{{ route('register') }}">
                @csrf
                <p>Your request will be reviewed by the main administrator before sign-in is enabled.</p>
                @if($errors->register->any())<div class="form-error"><ul>@foreach($errors->register->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <label>Full name<input name="name" value="{{ old('name') }}" autocomplete="name" required></label>
                <label>Official email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></label>
                <label>Requested role<select name="requested_role" required><option value="reader" @selected(old('requested_role')==='reader')>Reader</option><option value="admin" @selected(old('requested_role')==='admin')>Administrator</option></select></label>
                <div class="field-row"><label>Password<input type="password" name="password" autocomplete="new-password" required><small>At least 10 characters, including letters and numbers.</small></label><label>Confirm password<input type="password" name="password_confirmation" autocomplete="new-password" required></label></div>
                <button class="button button-lime" type="submit">Send registration request →</button>
            </form>
        </details>
    </section>
</main>
</body>
</html>
