<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::published()->upcoming()->paginate(6);
        $past     = Event::published()
            ->where('starts_at', '<', now())
            ->latest('starts_at')
            ->limit(3)
            ->get();

        return view('frontend.events.index', compact('upcoming', 'past'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->published()->firstOrFail();

        return view('frontend.events.show', compact('event'));
    }
}
