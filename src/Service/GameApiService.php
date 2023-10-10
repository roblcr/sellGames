<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class GameApiService
{
    private $httpClient;
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
        $this->httpClient = new Client([
            RequestOptions::VERIFY => false, // Désactive la vérification SSL
        ]);
    }

    public function getAllGameTitles(): array
    {
        $response = $this->httpClient->get('https://api.rawg.io/api/games?key=' . $this->apiKey);

        $data = json_decode($response->getBody(), true);

        $titles = [];
        foreach ($data['results'] as $game) {
            $titles[] = $game['name'];
        }

        return $titles;
    }

    public function searchGames(string $searchTerm): array
    {
        $url = 'https://api.rawg.io/api/games?key=' . $this->apiKey . '&search=' . urlencode($searchTerm);

        $response = $this->httpClient->get($url);

        $data = json_decode($response->getBody(), true);

        $titles = [];
        foreach ($data['results'] as $game) {
            $titles[] = $game['name'];
        }

        return $titles;
    }
}
