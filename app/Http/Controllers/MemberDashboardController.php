<?php

namespace App\Http\Controllers;

class MemberDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user   = auth()->user();
        $member = $user->member?->load(['card', 'activeSubscription', 'subscriptions' => fn($q) => $q->latest()->limit(5)]);

        return view('frontend.membre.dashboard', compact('user', 'member'));
    }
}
