<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\CinetPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    private const AMOUNT = 2000; // Montant de la cotisation annuelle en XOF

    public function __construct(private CinetPayService $cinetPay)
    {
        $this->middleware('auth');
    }

    /**
     * Initialise le paiement de la cotisation annuelle.
     */
    public function initiate(Request $request)
    {
        $user   = $request->user();
        $member = $user->member;

        abort_unless($member && $member->isActive(), 403, 'Compte non activé.');

        if ($member->hasPaidCurrentYear()) {
            return back()->with('error', 'Votre cotisation pour ' . now()->year . ' est déjà réglée.');
        }

        $subscription = Subscription::firstOrCreate(
            ['member_id' => $member->id, 'year' => now()->year],
            ['amount' => self::AMOUNT, 'currency' => 'XOF', 'status' => 'pending']
        );

        try {
            $result = $this->cinetPay->initiate([
                'amount'         => self::AMOUNT,
                'currency'       => 'XOF',
                'description'    => "Cotisation UFEEL {$subscription->year} — {$member->member_number}",
                'customer_name'  => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '',
                'metadata'       => ['subscription_id' => $subscription->id],
            ]);

            // Sauvegarde la référence de transaction en attente
            $subscription->update(['payment_reference' => $result['transaction_id']]);

            return redirect()->away($result['payment_url']);
        } catch (\RuntimeException $e) {
            Log::error('CinetPay initiate error', ['error' => $e->getMessage(), 'user' => $user->id]);
            return back()->with('error', 'Impossible d\'initier le paiement. Veuillez réessayer.');
        }
    }

    /**
     * Retour utilisateur après paiement (GET) — on vérifie le statut.
     */
    public function return(Request $request)
    {
        $transactionId = $request->query('transaction_id');

        if (! $transactionId) {
            return redirect()->route('membre.dashboard')->with('error', 'Paiement annulé ou non confirmé.');
        }

        return $this->processVerification($transactionId);
    }

    /**
     * Webhook CinetPay (POST) — notification serveur-à-serveur.
     */
    public function notify(Request $request)
    {
        $transactionId = $request->input('cpm_trans_id') ?? $request->input('transaction_id');

        if (! $transactionId) {
            return response('Missing transaction_id', 400);
        }

        $this->processVerification($transactionId);

        return response('OK', 200);
    }

    private function processVerification(string $transactionId)
    {
        $subscription = Subscription::where('payment_reference', $transactionId)->first();

        if (! $subscription) {
            return redirect()->route('membre.dashboard')->with('error', 'Transaction introuvable.');
        }

        if ($subscription->isPaid()) {
            return redirect()->route('membre.dashboard')->with('success', 'Cotisation déjà enregistrée.');
        }

        try {
            $data = $this->cinetPay->verify($transactionId);

            if ($this->cinetPay->isSuccessful($data)) {
                $subscription->markAsPaid('cinetpay', $transactionId);

                return redirect()->route('membre.dashboard')
                    ->with('success', 'Cotisation ' . $subscription->year . ' réglée avec succès ! Merci.');
            }

            return redirect()->route('membre.dashboard')
                ->with('error', 'Paiement non confirmé. Statut : ' . ($data['data']['status'] ?? 'inconnu'));
        } catch (\Exception $e) {
            Log::error('CinetPay verify error', ['error' => $e->getMessage()]);
            return redirect()->route('membre.dashboard')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }
}
