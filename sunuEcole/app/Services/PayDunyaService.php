<?php

namespace App\Services;

use GuzzleHttp\Client;
use Paydunya\Setup as PaydunyaSetup;

class PayDunyaService
{
    protected $client;
    protected $masterKey;
    protected $publicKey;
    protected $privateKey;
    protected $token;
    protected $baseUrl = 'https://app.paydunya.com/api/v1/checkout-invoice/create';

    public function __construct()
    {
        $this->client = new Client();
        $this->masterKey = config('paydunya.master_key');
        $this->publicKey = config('paydunya.public_key');
        $this->privateKey = config('paydunya.private_key');
        $this->token = config('paydunya.token');

        PaydunyaSetup::setMasterKey($this->masterKey);
        PaydunyaSetup::setPublicKey($this->publicKey);
        PaydunyaSetup::setPrivateKey($this->privateKey);
        PaydunyaSetup::setMode(config('paydunya.mode'));
        PaydunyaSetup::setToken($this->token);
    }

    public function createInvoice($invoiceData)
    {
        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'X-Paydunya-Master-Key' => $this->masterKey,
                    'X-Paydunya-Private-Key' => $this->privateKey,
                    'X-Paydunya-Public-Key' => $this->publicKey,
                    'X-Paydunya-Token' => $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $invoiceData,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
