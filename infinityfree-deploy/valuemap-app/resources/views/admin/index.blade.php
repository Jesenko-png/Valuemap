@extends('layouts.admin')
@section('title','Content')
@section('content')
<div class="admin-title"><div><p class="eyebrow">Content management</p><h1>Project content</h1><p>{{ $items->total() }} content items · {{ $messageCount }} contact messages · {{ $subscriberCount }} newsletter subscribers @if(auth()->user()->isMainAdmin())· <a href="{{ route('admin.users.index') }}">{{ $pendingUsers }} pending users</a>@endif</p></div><a class="button" href="{{ route('admin.content.create') }}">Add content +</a></div>
<div class="admin-filters"><a @class(['active'=>!$type]) href="{{ route('admin.index') }}">All</a>@foreach(\App\Models\ContentItem::TYPES as $filter)<a @class(['active'=>$type===$filter]) href="{{ route('admin.index',['type'=>$filter]) }}">{{ str_replace('_',' ',ucfirst($filter)) }}</a>@endforeach</div>
<p><a href="{{ route('admin.index',['review'=>'pending', 'type'=>$type]) }}">Awaiting approval ({{ $pendingContent }})</a> @if($review) · <a href="{{ route('admin.index',['type'=>$type]) }}">Clear approval filter</a>@endif</p>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Type</th><th>Title</th><th>Status</th><th>Visibility</th><th>Date</th><th>Actions</th></tr></thead><tbody>
@forelse($items as $item)
<tr><td><span class="tag">{{ $item->type_label }}</span></td><td><strong>{{ $item->title }}</strong><small>{{ $item->reference_code }}</small></td><td>{{ ucfirst($item->status) }}</td><td>{{ $item->visibility_label }}</td><td>{{ optional($item->published_at)->format('d M Y') ?: '—' }}</td><td class="table-actions">
    <a href="{{ route('admin.content.edit',$item) }}">Edit / review</a>
    @if($item->visibility_label === 'Public')<a href="{{ route('content.show',['contentItem'=>$item->slug]) }}" target="_blank" rel="noopener">View ↗</a>@endif
    @if(auth()->user()->isMainAdmin() && $item->approval_status === 'pending')
        <form method="post" action="{{ route('admin.content.approve',$item) }}">@csrf @method('PATCH')<button type="submit">Approve</button></form>
        <form method="post" action="{{ route('admin.content.return',$item) }}">@csrf @method('PATCH')<button type="submit">Return to draft</button></form>
    @endif
    <form method="post" action="{{ route('admin.content.destroy',$item) }}" onsubmit="return confirm('Delete this content item?')">@csrf @method('DELETE')<button type="submit">Delete</button></form>
</td></tr>
@empty<tr><td colspan="6" class="empty-cell">No matching content items.</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $items->links() }}</div>
@endsection
