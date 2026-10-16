@extends('layouts.admin')
@section('title', $partner->exists ? 'Edit partner' : 'Add partner')
@section('content')
@php($contacts = old('contacts', $partner->contacts ?: [['name' => '', 'position' => '', 'email' => '']]))
<div class="admin-title"><div><a class="back-link" href="{{ route('admin.partners.index') }}">← Back to partners</a><h1>{{ $partner->exists ? 'Edit partner' : 'Add partner' }}</h1></div></div>
<form class="admin-form" method="post" enctype="multipart/form-data" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}">@csrf @if($partner->exists)@method('PUT')@endif
    @if($errors->any())<div class="form-error"><strong>Please correct the form:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <fieldset><legend>Organisation</legend>
        <div class="field-row"><label>Organisation name *<input name="name" value="{{ old('name', $partner->name) }}" required></label><label>Initials *<input name="initials" value="{{ old('initials', $partner->initials) }}" maxlength="20" required></label></div>
        <div class="field-row"><label>Project role<input name="role" value="{{ old('role', $partner->role) }}" placeholder="Beneficiary, WP lead…"></label><label>Display order<input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $partner->sort_order ?: 0) }}"></label></div>
        <label>Short description<textarea name="description" rows="5">{{ old('description', $partner->description) }}</textarea></label>
        <label class="check-field"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->exists ? $partner->is_active : true))> Show this partner publicly</label>
    </fieldset>
    <fieldset><legend>Location and map</legend>
        <div class="field-row"><label>Country *<input name="country" value="{{ old('country', $partner->country) }}" required></label><label>Country code *<input name="country_code" value="{{ old('country_code', $partner->country_code) }}" minlength="3" maxlength="3" placeholder="e.g. ESP" required><small>Three-letter code used to highlight the country on the map.</small></label></div>
        <label>City or location<input name="location" value="{{ old('location', $partner->location) }}"></label>
        <div class="field-row"><label>Latitude *<input type="number" name="latitude" step="0.0000001" min="-90" max="90" value="{{ old('latitude', $partner->latitude) }}" required></label><label>Longitude *<input type="number" name="longitude" step="0.0000001" min="-180" max="180" value="{{ old('longitude', $partner->longitude) }}" required></label></div>
        <div class="field-row"><label>Marker X offset<input type="number" name="map_offset_x" step="0.1" min="-100" max="100" value="{{ old('map_offset_x', $partner->map_offset_x ?: 0) }}"><small>Only use when two markers overlap.</small></label><label>Marker Y offset<input type="number" name="map_offset_y" step="0.1" min="-100" max="100" value="{{ old('map_offset_y', $partner->map_offset_y ?: 0) }}"></label></div>
    </fieldset>
    <fieldset><legend>Logo and website</legend>
        <label>Official website<input type="url" name="website_url" value="{{ old('website_url', $partner->website_url) }}" placeholder="https://"></label>
        <label>Partner logo <small>JPG, PNG or WebP · max 5 MB</small><input type="file" name="logo" accept="image/jpeg,image/png,image/webp">@if($partner->logo_path)<span class="current-partner-logo"><img src="{{ asset('storage/'.$partner->logo_path) }}" alt="Current {{ $partner->name }} logo"><em>{{ basename($partner->logo_path) }}</em></span>@endif</label>
        @if($partner->logo_path)<label class="check-field"><input type="checkbox" name="remove_logo" value="1"> Remove current logo</label>@endif
    </fieldset>
    <fieldset><legend>Contact persons</legend><p class="fieldset-note">Add only contacts approved for public display on the Consortium page.</p>
        <div class="contact-editor" data-contact-list>
            @foreach($contacts as $index => $contact)
                <div class="contact-editor-row" data-contact-row><div class="field-row"><label>Name<input name="contacts[{{ $index }}][name]" value="{{ $contact['name'] ?? '' }}"></label><label>Position<input name="contacts[{{ $index }}][position]" value="{{ $contact['position'] ?? '' }}"></label></div><div class="contact-email-row"><label>Official email<input type="email" name="contacts[{{ $index }}][email]" value="{{ $contact['email'] ?? '' }}"></label><button type="button" data-remove-contact>Remove</button></div></div>
            @endforeach
        </div>
        <button class="button button-outline add-contact-button" type="button" data-add-contact>Add another contact +</button>
        <template data-contact-template><div class="contact-editor-row" data-contact-row><div class="field-row"><label>Name<input name="contacts[__INDEX__][name]"></label><label>Position<input name="contacts[__INDEX__][position]"></label></div><div class="contact-email-row"><label>Official email<input type="email" name="contacts[__INDEX__][email]"></label><button type="button" data-remove-contact>Remove</button></div></div></template>
    </fieldset>
    <button class="button" type="submit">{{ $partner->exists ? 'Save partner' : 'Create partner' }}</button>
</form>
@endsection
