<?php

namespace pizzashop\gateway\app\renderer;

use GuzzleHttp\Client;

class GuzzleRequest {

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function MakeRequest($method, $domain, $url, $data = false, $headers = false)
    {
        if($domain == 'catalogue') {
            $url = 'http://host.docker.internal:2090/api/' . $url;
        } else if($domain == 'commande') {
            $url = 'http://host.docker.internal:2080/api/' . $url;
        } else {
            $url = 'http://host.docker.internal:2100/api/' . $url;
        }

        $client = new Client();
        if ($headers) {
            $response = $client->request($method, $url, [
                'headers' => [
                    'Authorization' => $headers
                ],
                'json' => $data
            ]);
        } else {
            $response = $client->request($method, $url, [
                'json' => $data
            ]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}