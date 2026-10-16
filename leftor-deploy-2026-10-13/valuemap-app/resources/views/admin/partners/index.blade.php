@extends('layouts.admin')
@section('title', 'Partners')
@section('content')
<div class="admin-title">
    <div><p class="eyebrow">Consortium management</p><h1>Partners</h1><p>{{ $partners->count() }} organisations · {{ $partners->where('is_active', true)->count() }} visible on the website</p></div>
    <a class="button" href="{{ route('admin.partners.create') }}">Add partner +</a>
</div>
<div class="admin-table-wrap">
    <table class="admin-table partners-admin-table">
        <thead><tr><th>Order</th><th>Organisation</th><th>Country</th><th>Role</th><th>Contacts</th><th>Visibility</th><th></th></tr></thead>
        <tbody>
            @forelse($partners as $partner)
                <tr>
                    <td>{{ $partner->sort_order }}</td>
                    <td><span class="admin-partner-identity">@if($partner->logo_path)<img src="{{ asset('storage/'.$partner->logo_path) }}" alt="">@else<i>{{ $partner->initials }}</i>@endif<span><strong>{{ $partner->name }}</strong><small>{{ $partner->location ?: 'Location not specified' }}</small></span></span></td>
                    <td>{{ $partner->country }} <small>{{ $partner->country_code }}</small></td>
                    <td>{{ $partner->role ?: '—' }}</td>
                    <td>{{ count($partner->contacts ?? []) }}</td>
                    <td><span @class(['approval-status', 'approved' => $partner->is_active, 'pending' => ! $partner->is_active])>{{ $partner->is_active ? 'Visible' : 'Hidden' }}</span></td>
                    <td class="table-actions"><a href="{{ route('admin.partners.edit', $partner) }}">Edit</a><form method="post" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Delete this partner?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty-cell">No partners yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
