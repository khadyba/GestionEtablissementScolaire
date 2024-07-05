<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayDunyaService
{
    protected $baseUrl = 'https://app.paydunya.com/api/v1/checkout-invoice/create';

    public function createInvoice($invoiceData)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'PAYDUNYA-MASTER-KEY' => config('services.paydunya.master_key'),
            'PAYDUNYA-PRIVATE-KEY' => config('services.paydunya.private_key'),
            'PAYDUNYA-PUBLIC-KEY' => config('services.paydunya.public_key'),
            'PAYDUNYA-TOKEN' => config('services.paydunya.token'),
        ])->post($this->baseUrl, $invoiceData);

        return $response->json();
    }
}

