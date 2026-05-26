<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CinetPayService
{
    private string $apiKey;
    private string $siteId;
    private string $baseUrl = 'https://api-checkout.cinetpay.com/v2';

    public function __construct()
    {
        $this->apiKey = config('services.cinetpay.api_key');
        $this->siteId = config('services.cinetpay.site_id');
    }

    /**
     * Initialise un paiement et retourne l'URL de paiement CinetPay.
     *
     * @return array{payment_url: string, transaction_id: string}
     */
    public function initiate(array $params): array
    {
        $transactionId = 'UFEEL-' . strtoupper(Str::random(12));

        $response = Http::post("{$this->baseUrl}/payment", [
            'apikey'          => $this->apiKey,
            'site_id'         => $this->siteId,
            'transaction_id'  => $transactionId,
            'amount'          => $params['amount'],
            'currency'        => $params['currency'] ?? 'XOF',
            'description'     => $params['description'],
            'return_url'      => route('payment.return'),
            'notify_url'      => route('payment.notify'),
            'customer_name'   => $params['customer_name'],
            'customer_email'  => $params['customer_email'],
            'customer_phone_number' => $params['customer_phone'] ?? '',
            'channels'        => 'ALL',
            'metadata'        => json_encode($params['metadata'] ?? []),
        ]);

        $data = $response->json();

        if (($data['code'] ?? null) !== '201') {
            throw new \RuntimeException('CinetPay: ' . ($data['message'] ?? 'Erreur inconnue'));
        }

        return [
            'transaction_id' => $transactionId,
            'payment_url'    => $data['data']['payment_url'],
        ];
    }

    /**
     * Vérifie le statut d'une transaction auprès de CinetPay.
     */
    public function verify(string $transactionId): array
    {
        $response = Http::post("{$this->baseUrl}/payment/check", [
            'apikey'         => $this->apiKey,
            'site_id'        => $this->siteId,
            'transaction_id' => $transactionId,
        ]);

        return $response->json();
    }

    public function isSuccessful(array $verifyResponse): bool
    {
        return ($verifyResponse['data']['status'] ?? null) === 'ACCEPTED';
    }
}
