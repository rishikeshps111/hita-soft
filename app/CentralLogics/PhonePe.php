<?php

namespace App\CentralLogics;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PhonePe
{
    protected static ?self $instance = null;

    protected string $baseUrl;
    protected string $clientId;
    protected string $clientVersion;
    protected string $clientSecret;
    protected string $grantType;
    protected string $environment;

    const MERCHANT_PREFIXES = [
        'order' => 'OD',
        'subscription' => 'SUB',
    ];

    const ENV_SANDBOX = 'sandbox';
    const ENV_PRODUCTION = 'production';

    private function __construct()
    {
        $this->environment = config('services.phonepe.env', self::ENV_SANDBOX);
        $config = config("services.phonepe.{$this->environment}");
        
        $this->baseUrl = $config['base_url'];
        $this->clientId = $config['client_id'];
        $this->clientVersion = $config['client_version'];
        $this->clientSecret = $config['client_secret'];
        $this->grantType = $config['grant_type'];
    }

    /**
     * Get an instance of PhonePe.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the token endpoint URL based on environment.
     *
     * @return string
     */
    protected function getTokenEndpoint(): string
    {
        return $this->environment === self::ENV_SANDBOX
            ? "{$this->baseUrl}/apis/pg-sandbox/v1/oauth/token"
            : "{$this->baseUrl}/apis/identity-manager/v1/oauth/token";
    }

    /**
     * Get the order endpoint URL based on environment.
     * For website integration, use /pay endpoint (not /sdk/order which is for mobile)
     *
     * @return string
     */
    protected function getOrderEndpoint(): string
    {
        return $this->environment === self::ENV_SANDBOX
            ? "{$this->baseUrl}/apis/pg-sandbox/checkout/v2/pay"
            : "{$this->baseUrl}/apis/pg/checkout/v2/pay";
    }

    /**
     * Get the status check endpoint URL based on environment.
     *
     * @param string $merchantOrderId
     * @return string
     */
    protected function getStatusEndpoint(string $merchantOrderId): string
    {
        return $this->environment === self::ENV_SANDBOX
            ? "{$this->baseUrl}/apis/pg-sandbox/checkout/v2/order/{$merchantOrderId}/status"
            : "{$this->baseUrl}/apis/pg/checkout/v2/order/{$merchantOrderId}/status";
    }

    /**
     * Get or generate PhonePe access token.
     *
     * @return string
     * @throws RuntimeException
     */
    public function getAccessToken(): string
    {
        $cacheKey = "phonepe_access_token_{$this->environment}";

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if ($cached['expires_at'] > now()->timestamp) {
                return $cached['access_token'];
            }
        }

        $httpClient = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]);

        // Disable SSL verification for local environment
        if (config('app.env') === 'local') {
            $httpClient = $httpClient->withOptions([
                'verify' => false,
            ]);
        }

        $response = $httpClient->asForm()->post($this->getTokenEndpoint(), [
            'client_id' => $this->clientId,
            'client_version' => $this->clientVersion,
            'client_secret' => $this->clientSecret,
            'grant_type' => $this->grantType,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Failed to generate PhonePe access token: ' . $response->body());
        }

        $data = $response->json();

        Cache::put($cacheKey, [
            'access_token' => $data['access_token'],
            'expires_at' => $data['expires_at'],
        ], now()->addSeconds($data['expires_in']));

        return $data['access_token'];
    }

    /**
     * Create a PhonePe order.
     *
     * @param string $merchantOrderId
     * @param float $amount
     * @param string $redirectUrl
     * @param int $expireAfter
     * @return array
     * @throws RuntimeException
     */
    public function createOrder(string $merchantOrderId, float $amount, string $redirectUrl, int $expireAfter = 1200): array
    {
        $accessToken = $this->getAccessToken();

        // Convert amount to paise and ensure it's an integer
        $amountInPaise = (int) round($amount * 100);

        $payload = [
            'merchantOrderId' => $merchantOrderId,
            'amount' => $amountInPaise,
            'expireAfter' => $expireAfter,
            'paymentFlow' => [
                'type' => 'PG_CHECKOUT',
                'message' => 'Processing payment...',
                'merchantUrls' => [
                    'redirectUrl' => $redirectUrl,
                ],
            ],
        ];

        $httpClient = Http::withHeaders([
            'Authorization' => "O-Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ]);

        // Disable SSL verification for local environment
        if (config('app.env') === 'local') {
            $httpClient = $httpClient->withOptions([
                'verify' => false,
            ]);
        }

        $response = $httpClient->post($this->getOrderEndpoint(), $payload);

        // Log the request and response for debugging
        \Log::info('PhonePe Order Request: ', [
            'endpoint' => $this->getOrderEndpoint(),
            'payload' => $payload,
        ]);
        \Log::info('PhonePe Order Response: ', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->failed()) {
            $errorMessage = 'Failed to create PhonePe order: ' . $response->body();
            \Log::error($errorMessage);
            throw new RuntimeException($errorMessage);
        }

        $data = $response->json();

        // PhonePe API already returns the complete redirectUrl in the response
        // No need to construct it manually - just use the one from API response

        return $data;
    }

    /**
     * Check the status of a PhonePe order.
     *httpClient = Http::withHeaders([
            'Authorization' => "O-Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ]);

        // Disable SSL verification for local environment
        if (config('app.env') === 'local') {
            $httpClient = $httpClient->withOptions([
                'verify' => false,
            ]);
        }

        $response = $httpClientrows RuntimeException
     */
    public function checkOrderStatus(string $merchantOrderId): array
    {
        $accessToken = $this->getAccessToken();

        $httpClient = Http::withHeaders([
            'Authorization' => "O-Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ]);

        // Disable SSL verification for local environment
        if (config('app.env') === 'local') {
            $httpClient = $httpClient->withOptions([
                'verify' => false,
            ]);
        }

        $response = $httpClient->get($this->getStatusEndpoint($merchantOrderId), [
            'details' => true,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Failed to check PhonePe order status: ' . $response->body());
        }

        return $response->json();
    }
}
