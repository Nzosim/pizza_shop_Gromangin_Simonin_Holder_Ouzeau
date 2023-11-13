<?php

namespace pizzashop\shop\app\actions;

use GuzzleHttp\Client;
use pizzashop\shop\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ConnectionAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $client = new Client([
            // Base URI pour des requêtes relatives
            'base_uri' => 'http://host.docker.internal:2780/api/users/',
            // options par défaut pour les requêtes
            'timeout' => 10.0,
        ]);

        $authorizationHeader = $rq->getHeaderLine('Authorization');

        $data = $client->request('POST', 'signin', [
            'headers' => [
                'Authorization' => $authorizationHeader
            ]
        ]);
        $code = 200;

        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json');
    }
}


