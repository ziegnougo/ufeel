<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberCard;

class MemberCardService
{
    public function issueCard(Member $member): MemberCard
    {
        MemberCard::where('member_id', $member->id)->update(['is_active' => false]);

        return MemberCard::create([
            'member_id'     => $member->id,
            'card_number'   => $this->generateCardNumber($member),
            'qr_code_token' => MemberCard::generateToken(),
            'issued_at'     => now(),
            'expires_at'    => now()->endOfYear(),
            'is_active'     => true,
        ]);
    }

    public function renewCard(Member $member): MemberCard
    {
        return $this->issueCard($member);
    }

    private function generateCardNumber(Member $member): string
    {
        return sprintf('UFEEL-%d-%05d', now()->year, $member->id);
    }
}
