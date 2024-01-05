<?php

namespace pizzashop\shop\app\actions;

use GuzzleHttp\Client;
use pizzashop\shop\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ConnectionAction permet de se connecter depuis l'api commande
 */
class ConnectionAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // création du client guzzle
        $client = new Client([
            'base_uri' => 'http://docketu.iutnc.univ-lorraine.fr:43225/api/users/',
            'timeout' => 10.0,
        ]);

        // récupération du header Authorization
        $authorizationHeader = $rq->getHeaderLine('Authorization');

        // requête vers l'api users
        $data = $client->request('POST', 'signin', [
            'headers' => [
                'Authorization' => $authorizationHeader
            ]
        ]);
        $code = 200;

        // retour de la réponse
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}


