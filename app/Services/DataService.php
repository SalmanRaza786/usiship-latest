<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('WMS_URL'); // config('services.api.url'); // Example of using config for base URL
    }

    /**
     * Fetch data from the API with optional page token.
     *
     * @param string $endpoint
     * @param string|null $pageToken
     * @return array
     * @throws \Exception
     */
    public function getData(string $endpoint, ?string $pageToken = null): array
    {
        $response = Http::get($this->baseUrl . $endpoint, [
            'page_token' => $pageToken
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from URL.');
        }

        return $response->json(); // or $response->body() if you prefer raw data
    }

    /**
     * Fetch all data from the paginated API.
     *
     * @param string $endpoint
     * @return array
     * @throws \Exception
     */
    public function fetchAllData(string $endpoint): array
    {
        $allData = [];
        $pageToken = null;

        do {
            $response = $this->getData($endpoint, $pageToken);

            if (isset($response['data'])) {
                $allData = array_merge($allData, $response['data']);
            }

            $pageToken = $response['next_token'] ?? null;

        } while ($pageToken);

        return $allData;
    }

}
