<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function results(Request $request): View
    {
        return $this->listing($request, 'results', ContentItem::RESULT_TYPES);
    }

    public function news(Request $request): View
    {
        return $this->listing($request, 'news', ContentItem::MEDIA_TYPES);
    }

    public function show(ContentItem $contentItem): View
    {
        abort_unless($contentItem->is_public && (!$contentItem->published_at || $contentItem->published_at->isPast()), 404);

        return view('content.show', compact('contentItem'));
    }

    private function listing(Request $request, string $section, array $types): View
    {
        $activeType = in_array($request->string('type')->toString(), $types, true) ? $request->string('type')->toString() : null;
        $search = trim($request->string('q')->toString());
        $items = ContentItem::visible()->whereIn('type', $types)
            ->when($activeType, fn ($query) => $query->where('type', $activeType))
            ->when($search, fn ($query) => $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%")))
            ->orderByRaw("CASE WHEN event_date IS NOT NULL THEN event_date ELSE published_at END DESC")
            ->orderBy('sort_order')->paginate(9)->withQueryString();

        return view('content.index', compact('items', 'section', 'types', 'activeType', 'search'));
    }
}
