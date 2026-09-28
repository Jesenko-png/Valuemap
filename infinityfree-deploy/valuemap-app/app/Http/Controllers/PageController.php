<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Partner;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latestNews' => ContentItem::visible()->whereIn('type', ContentItem::MEDIA_TYPES)->latest('published_at')->limit(3)->get(),
            'latestResults' => ContentItem::visible()->whereIn('type', ContentItem::RESULT_TYPES)->latest('published_at')->limit(3)->get(),
            'partners' => Partner::visible()->get(),
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
        return view('pages.consortium', ['partners' => Partner::visible()->get()]);
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
}
