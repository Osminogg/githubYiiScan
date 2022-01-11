<?php

namespace app\models;

use GuzzleHttp\Client;

class Scanner
{
    public static function start($username)
    {
        $url = "https://api.github.com/orgs/{$username}/repos?page=1&per_page=10&sort=updated";
        $client = new Client();
        $response = $client->request('GET', $url);

        if($response->getStatusCode() !== 200)
        {
            throw new \Exception("Не удалось получить данные c аккаунта " . $username);
        }
        return json_decode($response->getBody(), true);
    }
}