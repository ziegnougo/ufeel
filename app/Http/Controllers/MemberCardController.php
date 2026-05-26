<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberCardController extends Controller
{
    public function pdf(Member $member)
    {
        $member->load(['user', 'card']);

        abort_unless($member->card?->isValid(), 404);

        $pdf = Pdf::loadView('frontend.member-card-pdf', compact('member'))
            ->setPaper([0, 0, 153.07, 242.65], 'portrait'); // CR80 en points (85.6mm x 54mm)

        return $pdf->download("carte-{$member->member_number}.pdf");
    }
}
