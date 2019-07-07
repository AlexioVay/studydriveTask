<?php
namespace App;

use GuzzleHttp\Exception\GuzzleException;

class Helpers {

    public static function curl($url, $query = null) {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', $url, ['query' => $query]);
        } catch (GuzzleException $e) {
            print_r($e);
        }

        #$statusCode = $response->getStatusCode();
        $content = $response->getBody();

        return json_decode($content);
    }

}