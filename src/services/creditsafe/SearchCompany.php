<?php

declare(strict_types=1);

namespace Services\Creditsafe;

require 'config/creditsafe.php';

use GuzzleHttp\Client;
use Exception;

class SearchCompany
{

    public static function byVat(string $accessToken, string $vat): array
    {
        $config = include 'config/creditsafe.php';

        $companySearchUrl = $config['companies_url'];

        $client = new Client();

        try {
            $companySearchResponse = $client->request('GET', $companySearchUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ],
                'query' => [
                    'countries' => 'IT',
                    'vatNo' => $vat
                ]
            ]);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        $companiesData = $companySearchResponse->getBody()->getContents();

        return json_decode($companiesData, true);
    }
}
