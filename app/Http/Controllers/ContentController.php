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
        abort_unless(ContentItem::visible()->whereKey($contentItem->id)->exists(), 404);

        return view('content.show', compact('contentItem'));
    }

    private function listing(Request $request, string $section, array $types): View
    {
        $activeType = in_array($request->string('type')->toString(), $types, true) ? $request->string('type')->toString() : null;
        $search = trim($request->string('q')->toString());
        $category = trim($request->string('category')->toString());
        $categories = ContentItem::visible()->whereIn('type', $types)
            ->when($activeType, fn ($query) => $query->where('type', $activeType))
            ->whereNotNull('category')->where('category', '!=', '')->distinct()->orderBy('category')->pluck('category');
        $eventPeriod = $activeType === 'event' && in_array($request->string('period')->toString(), ['upcoming', 'past'], true)
            ? $request->string('period')->toString()
            : null;
        $items = ContentItem::visible()->whereIn('type', $types)
            ->when($activeType, fn ($query) => $query->where('type', $activeType))
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->when($eventPeriod === 'upcoming', fn ($query) => $query->where('event_date', '>=', now()))
            ->when($eventPeriod === 'past', fn ($query) => $query->where('event_date', '<', now()))
            ->when($search, fn ($query) => $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->orderByRaw('CASE WHEN type = \'event\' THEN event_date ELSE published_at END '.($eventPeriod === 'upcoming' ? 'ASC' : 'DESC'))
            ->orderByDesc('id')->paginate(9)->withQueryString();

        return view('content.index', compact('items', 'section', 'types', 'activeType', 'search', 'eventPeriod', 'category', 'categories'));
    }
}
