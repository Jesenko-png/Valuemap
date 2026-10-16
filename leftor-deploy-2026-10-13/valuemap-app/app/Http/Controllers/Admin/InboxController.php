<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InboxController extends Controller
{
    public function messages(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $messages = ContactMessage::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                foreach (['name', 'email', 'organisation', 'subject', 'message'] as $field) {
                    $query->orWhere($field, 'like', '%'.$search.'%');
                }
            }))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages', 'search'));
    }

    public function show(ContactMessage $message): View
    {
        return view('admin.messages.show', compact('message'));
    }

    public function subscribers(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $status = in_array($request->string('status')->toString(), ['active', 'pending', 'unsubscribed'], true)
            ? $request->string('status')->toString() : null;
        $subscribers = NewsletterSubscriber::query()
            ->when($search !== '', fn ($query) => $query->where('email', 'like', '%'.$search.'%'))
            ->when($status === 'active', fn ($query) => $query->active())
            ->when($status === 'pending', fn ($query) => $query->whereNull('confirmed_at')->whereNull('unsubscribed_at'))
            ->when($status === 'unsubscribed', fn ($query) => $query->whereNotNull('unsubscribed_at'))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin.subscribers', compact('subscribers', 'search', 'status'));
    }
}
