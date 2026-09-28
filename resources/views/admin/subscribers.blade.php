@extends('layouts.admin')
@section('title', 'Newsletter subscribers')
@section('content')
<div class="admin-title"><div><p class="eyebrow">Newsletter audience</p><h1>Newsletter subscribers</h1><p>{{ $subscribers->total() }} matching registrations</p></div></div>
<p>Only confirmed, active addresses should receive newsletter messages.</p>
<form class="publication-filters" method="get">
    <label>Search email<input type="search" name="q" value="{{ $search }}" placeholder="Email address"></label>
    <label>Status<select name="status"><option value="">All statuses</option><option value="active" @selected($status==='active')>Confirmed</option><option value="pending" @selected($status==='pending')>Pending confirmation</option><option value="unsubscribed" @selected($status==='unsubscribed')>Unsubscribed</option></select></label>
    <button class="button" type="submit">Search</button><a href="{{ route('admin.subscribers.index') }}">Reset</a>
</form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Email</th><th>Status</th><th>Registered</th><th>Confirmed</th><th>Unsubscribed</th><th>Consent recorded</th></tr></thead><tbody>
@forelse($subscribers as $subscriber)
<tr><td>{{ $subscriber->email }}</td><td>{{ $subscriber->status_label }}</td><td>{{ $subscriber->created_at->format('d M Y, H:i') }}</td><td>{{ $subscriber->confirmed_at?->format('d M Y, H:i') ?: '—' }}</td><td>{{ $subscriber->unsubscribed_at?->format('d M Y, H:i') ?: '—' }}</td><td>{{ $subscriber->consent_at?->format('d M Y, H:i') ?: 'Not recorded' }}</td></tr>
@empty<tr><td colspan="6">{{ $search !== '' || $status ? 'No registrations match your filters.' : 'No newsletter registrations yet.' }}</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $subscribers->links() }}</div>
@endsection
