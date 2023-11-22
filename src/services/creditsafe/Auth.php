<?php

declare(strict_types=1);

namespace Services\Creditsafe;

require 'vendor/autoload.php';
require 'config/creditsafe.php';

use GuzzleHttp\Client;
use Exception;

class Auth
{

    public static function authenticate(): string
    {
        $config = include 'config/creditsafe.php';

        $authUrl = $config['auth_url'];
        $authData = $config['auth_data'];

        $client = new Client();

        try {
            $authResponse = $client->request('POST', $authUrl, ['json' => $authData]);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        $responseBody = $authResponse->getBody()->getContents();
        $responseData = json_decode($responseBody, true);
        $accessToken = $responseData['token'];

        return $accessToken;
    }
}
