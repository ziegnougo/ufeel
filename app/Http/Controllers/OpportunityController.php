<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $opportunities = Opportunity::active()
            ->when($request->type, fn($q, $type) => $q->where('type', $type))
            ->latest()
            ->paginate(9);

        return view('frontend.opportunities.index', compact('opportunities'));
    }
}
