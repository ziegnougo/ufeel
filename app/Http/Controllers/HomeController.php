<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Opportunity;
use App\Models\Partner;
use App\Models\Post;
use App\Models\SiteStat;

class HomeController extends Controller
{
    public function index()
    {
        $posts        = Post::published()->latest('published_at')->limit(3)->get();
        $events       = Event::published()->upcoming()->limit(3)->get();
        $opportunities = Opportunity::active()->latest()->limit(4)->get();
        $partners     = Partner::where('is_active', true)->orderBy('display_order')->get();
        $stats        = SiteStat::all()->keyBy('key');

        return view('frontend.home', compact('posts', 'events', 'opportunities', 'partners', 'stats'));
    }
}
