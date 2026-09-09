<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latestNews' => ContentItem::visible()->whereIn('type', ContentItem::MEDIA_TYPES)->latest('published_at')->limit(3)->get(),
            'latestResults' => ContentItem::visible()->whereIn('type', ContentItem::RESULT_TYPES)->latest('published_at')->limit(3)->get(),
        ]);
    }

    public function about(): View { return view('pages.about'); }
    public function structure(): View { return view('pages.structure'); }
    public function consortium(): View { return view('pages.consortium'); }
    public function ecosystem(): View { return view('pages.ecosystem'); }
}
