@extends('layouts.app')
@section('title','My account')
@section('content')
<header class="page-hero compact"><p class="eyebrow">ValueMap account</p><h1>Welcome, <em>{{ auth()->user()->name }}.</em></h1><p>Your approved role is {{ strtolower(auth()->user()->role_label) }}.</p></header>
<section class="section account-section"><div><span class="tag">{{ auth()->user()->role_label }}</span><h2>Your account is active.</h2><p>Reader accounts can access the public ValueMap library and project updates. Publishing tools are available only to approved administrators.</p>@if(auth()->user()->canManageContent())<a class="button" href="{{ route('admin.index') }}">Open content dashboard →</a>@endif<form method="post" action="{{ route('logout') }}">@csrf<button class="button button-outline" type="submit">Sign out</button></form></div></section>
@endsection
