<?php

namespace App\Services\Payments;

use Exception;
use Illuminate\Support\Facades\Http;

class Thawani
{
    const TEST_BASE_URL = 'https://uatcheckout.thawani.om/api/v1';
    const LIVE_BASE_URL = 'https://checkout.thawani.om/api/v1';

    protected $secretKey;
    protected $publishableKey;
    protected $baseURL;
    protected $mode;

    public function __construct($secretKey, $publishableKey, $mode = 'test')
    {
        $this->secretKey = $secretKey;
        $this->publishableKey = $publishableKey;
        $this->mode = $mode;

        if ($mode == 'test') {
            $this->baseURL = self::TEST_BASE_URL;
        } else {
            $this->baseURL = self::LIVE_BASE_URL;
        }
    }

    public function createCheckoutSession($data)
    {
        $response = Http::baseUrl($this->baseURL)->withHeaders([
            'thawani-api-key' => $this->secretKey,
            // 'content-type' => 'application/json'
        ])->asJson()->post('checkout/session', $data);

        $body = $response->json();
        if ($body['success'] == true && $body['code'] == 2004) {
            return $body['data']['session_id'];
        }

        throw new Exception($body['description'], $body['code']);
    }

    public function getCheckoutSession($session_id)
    {
        $response = Http::baseUrl($this->baseURL)
            ->withHeaders([
                'thawani-api-key' => $this->secretKey,
            ])->get('checkout/session/', $session_id)
            ->json();

        if($response['success'] == true && $response['code'] == 2000){
            return $response;
        }
        throw new Exception($response['description'], $response['code']);
    }

    public function getPayUrl($sessionID)
    {
        if ($this->mode == 'test') {
            return "https://uatcheckout.thawani.om/pay/{$sessionID}?key={$this->publishableKey}";
        } else {
            return "https://checkout.thawani.om/pay/{$sessionID}?key={$this->publishableKey}";
        }
    }
}
