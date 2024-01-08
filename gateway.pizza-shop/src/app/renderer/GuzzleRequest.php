<?php

namespace pizzashop\gateway\app\renderer;

use GuzzleHttp\Client;

class GuzzleRequest {

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function MakeRequest($method, $url, $data = false, $headers = false)
    {
        $client = new Client();
        if ($headers) {
            $response = $client->request($method, $url, [
                'headers' => [
                    'Authorization' => $headers
                ],
                'json' => json_encode($data)
            ]);
        } else {
            $response = $client->request($method, $url, [
                'json' => $data
            ]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}