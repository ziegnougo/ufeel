<?php

namespace App\Http\Controllers;

use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::published()
            ->when(! auth()->check(), fn($q) => $q->public())
            ->orderBy('title')
            ->get()
            ->groupBy('type');

        return view('frontend.resources.index', compact('resources'));
    }
}
