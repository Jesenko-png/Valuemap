<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Partner;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latestNews' => ContentItem::visible()->whereIn('type', ContentItem::MEDIA_TYPES)->latest('published_at')->limit(3)->get(),
            'latestResults' => ContentItem::visible()->whereIn('type', ContentItem::RESULT_TYPES)->latest('published_at')->limit(3)->get(),
            'partners' => $this->visiblePartners(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function impact(): View
    {
        return view('pages.impact');
    }

    public function structure(): View
    {
        return view('pages.structure');
    }

    public function consortium(): View
    {
        return view('pages.consortium', ['partners' => $this->visiblePartners()]);
    }

    public function ecosystem(): View
    {
        return view('pages.ecosystem');
    }

    public function privacy(): View
    {
        return view('pages.policy', ['policy' => 'privacy']);
    }

    public function cookies(): View
    {
        return view('pages.policy', ['policy' => 'cookies']);
    }

    public function accessibility(): View
    {
        return view('pages.policy', ['policy' => 'accessibility']);
    }

    public function sitemap(): Response
    {
        return response()->view('sitemap', [
            'staticRoutes' => ['home', 'about', 'impact', 'structure', 'consortium', 'ecosystem', 'results', 'news', 'contact', 'privacy', 'cookies', 'accessibility'],
            'items' => ContentItem::visible()->select(['slug', 'updated_at'])->get(),
        ])->header('Content-Type', 'application/xml');
    }

    private function visiblePartners(): Collection
    {
        $partners = Partner::visible()->get();

        if ($partners->isNotEmpty()) {
            return $partners;
        }

        // A fresh hosted database may have the partners table but no seed rows.
        // Keep the public directory populated until the records are imported.
        $countryCodes = ['Hungary' => 'HUN', 'Spain' => 'ESP', 'Portugal' => 'PRT', 'Sweden' => 'SWE', 'Bosnia and Herzegovina' => 'BIH', 'Ireland' => 'IRL'];

        return collect(config('valuemap.partners'))->values()->map(fn (array $partner, int $index) => new Partner([
            'name' => $partner['name'],
            'initials' => $partner['initials'],
            'country' => $partner['country'],
            'country_code' => $partner['country_code'] ?? $countryCodes[$partner['country']],
            'location' => $partner['location'] ?? $partner['country'],
            'latitude' => $partner['latitude'],
            'longitude' => $partner['longitude'],
            'map_offset_x' => $partner['map_offset_x'] ?? 0,
            'map_offset_y' => $partner['map_offset_y'] ?? 0,
            'role' => $partner['role'] ?? null,
            'description' => $partner['description'] ?? null,
            'website_url' => $partner['url'] ?? null,
            'contacts' => [],
            'sort_order' => $index + 1,
            'is_active' => true,
        ]));
    }
}
