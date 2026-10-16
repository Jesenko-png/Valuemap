@extends('layouts.admin')
@section('title', 'Contact messages')
@section('content')
<div class="admin-title"><div><p class="eyebrow">Project inbox</p><h1>Contact messages</h1><p>{{ $messages->total() }} matching messages</p></div></div>
<form class="publication-filters" method="get">
    <label>Search messages<input type="search" name="q" value="{{ $search }}" placeholder="Name, email, organisation, subject or message"></label>
    <button class="button" type="submit">Search</button><a href="{{ route('admin.messages.index') }}">Reset</a>
</form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Received</th><th>Sender</th><th>Organisation</th><th>Subject</th><th></th></tr></thead><tbody>
@forelse($messages as $message)
<tr><td>{{ $message->created_at->format('d M Y, H:i') }}</td><td><strong>{{ $message->name }}</strong><small>{{ $message->email }}</small></td><td>{{ $message->organisation ?: '—' }}</td><td>{{ $message->subject }}</td><td><a href="{{ route('admin.messages.show', $message) }}">Read message →</a></td></tr>
@empty<tr><td colspan="5">{{ $search !== '' ? 'No messages match your search.' : 'No contact messages received yet.' }}</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $messages->links() }}</div>
@endsection
