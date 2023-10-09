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
            RequestOptions::VERIFY => false, // Désactiver la vérification SSL
        ]);
    }

    public function getAllGameTitles(): array
    {
        // Effectuez une requête GET vers l'API pour obtenir les titres des jeux vidéo.
        $response = $this->httpClient->get('https://api.rawg.io/api/games?key=' . $this->apiKey);

        // Traitez la réponse JSON
        $data = json_decode($response->getBody(), true);

        // Extrayez les titres des jeux vidéo de la réponse.
        $titles = [];
        foreach ($data['results'] as $game) {
            $titles[] = $game['name'];
        }

        return $titles;
    }

    public function searchGames(string $searchTerm): array
    {
        $url = 'https://api.rawg.io/api/games?key=' . $this->apiKey . '&search=' . urlencode($searchTerm);

        // Effectuez une requête GET vers l'API pour obtenir les résultats de recherche.
        $response = $this->httpClient->get($url);

        // Traitez la réponse JSON (supposez que l'API renvoie des données au format JSON).
        $data = json_decode($response->getBody(), true);

        // Extrayez les titres des jeux vidéo de la réponse.
        $titles = [];
        foreach ($data['results'] as $game) {
            $titles[] = $game['name'];
        }

        return $titles;
    }

    // public function getGameImage(string $title): ?string
    // {
    //     $url = 'https://api.rawg.io/api/games?key=' . $this->apiKey . '&search=' . urlencode($title);

    //     $response = $this->httpClient->get($url);

    //     $data = json_decode($response->getBody(), true);

    //     // Assurez-vous que le jeu a été trouvé dans les résultats
    //     if (!empty($data['results'][0]['background_image'])) {
    //         return $data['results'][0]['background_image'];
    //     }

    //     return null;
    // }
}
