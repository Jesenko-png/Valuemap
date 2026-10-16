<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ContentItem;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Request $request): View
    {
        $type = in_array($request->string('type')->toString(), ContentItem::TYPES, true) ? $request->string('type')->toString() : null;
        $review = $request->query('review') === 'pending';
        $items = ContentItem::query()->when($type, fn ($q) => $q->where('type', $type))
            ->when($review, fn ($q) => $q->where('approval_status', 'pending'))->latest()->paginate(15)->withQueryString();

        return view('admin.index', [
            'items' => $items,
            'type' => $type,
            'review' => $review,
            'pendingContent' => ContentItem::where('approval_status', 'pending')->count(),
            'messageCount' => ContactMessage::count(),
            'subscriberCount' => NewsletterSubscriber::active()->count(),
            'pendingUsers' => $request->user()->isMainAdmin() ? User::where('is_approved', false)->count() : 0,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', ['item' => new ContentItem]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data = $this->storeUploads($request, $data);
        ContentItem::create($data);

        return redirect()->route('admin.index')->with('success', $data['approval_status'] === 'pending' ? 'Content saved and submitted to the main administrator for approval.' : 'Content item created.');
    }

    public function edit(ContentItem $contentItem): View
    {
        return view('admin.form', ['item' => $contentItem]);
    }

    public function update(Request $request, ContentItem $contentItem): RedirectResponse
    {
        $data = $this->validated($request);
        // Keep published links stable when a title changes.
        $data = $this->storeUploads($request, $data, $contentItem);
        $contentItem->update($data);

        return redirect()->route('admin.index')->with('success', $data['approval_status'] === 'pending' ? 'Changes submitted for approval. This item is hidden until approved again.' : 'Content item updated.');
    }

    public function approve(Request $request, ContentItem $contentItem): RedirectResponse
    {
        abort_unless($request->user()->isMainAdmin(), 403);
        abort_unless($contentItem->approval_status === 'pending' && $contentItem->is_public && $contentItem->status !== 'draft', 422);
        $contentItem->update(['approval_status' => 'approved', 'approved_by' => $request->user()->id, 'approved_at' => now()]);

        return back()->with('success', 'Publication approved. Future-dated items remain scheduled.');
    }

    public function returnToDraft(Request $request, ContentItem $contentItem): RedirectResponse
    {
        abort_unless($request->user()->isMainAdmin(), 403);
        $contentItem->update(['approval_status' => 'draft', 'status' => 'draft', 'is_public' => false, 'approved_by' => null, 'approved_at' => null]);

        return back()->with('success', 'Content returned to draft for corrections.');
    }

    public function destroy(ContentItem $contentItem): RedirectResponse
    {
        if ($contentItem->file_path) {
            Storage::disk('public')->delete($contentItem->file_path);
        }
        if ($contentItem->image_path) {
            Storage::disk('public')->delete($contentItem->image_path);
        }
        $contentItem->delete();

        return back()->with('success', 'Content item deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(ContentItem::TYPES)], 'title' => ['required', 'string', 'max:255'],
            'reference_code' => ['nullable', 'string', 'max:80'], 'excerpt' => ['nullable', 'string', 'max:800'],
            'body' => ['nullable', 'string'], 'partner' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'], 'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'], 'target_audience' => ['nullable', 'string', 'max:255'],
            'registration_url' => ['nullable', 'url', 'max:500'], 'agenda_url' => ['nullable', 'url', 'max:500'],
            'related_resources' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in(['draft', 'forthcoming', 'published', 'completed'])],
            'category' => ['nullable', 'string', 'max:100'], 'external_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $data['is_public'] = $request->boolean('is_public');
        $wantsPublication = $data['is_public'] && $data['status'] !== 'draft';
        $approved = $wantsPublication && $request->user()->isMainAdmin();
        $data['approval_status'] = $wantsPublication ? ($approved ? 'approved' : 'pending') : 'draft';
        $data['approved_by'] = $approved ? $request->user()->id : null;
        $data['approved_at'] = $approved ? now() : null;
        $data['category'] = isset($data['category']) ? trim($data['category']) : null;
        $data['sort_order'] ??= 0;
        unset($data['document'], $data['image']);

        return $data;
    }

    private function storeUploads(Request $request, array $data, ?ContentItem $item = null): array
    {
        if ($request->hasFile('document')) {
            if ($item?->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }
            $data['file_path'] = $request->file('document')->store('documents', 'public');
        }
        if ($request->hasFile('image')) {
            if ($item?->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image')->store('images', 'public');
        }

        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'item';
        $slug = $base;
        $i = 2;
        while (ContentItem::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
