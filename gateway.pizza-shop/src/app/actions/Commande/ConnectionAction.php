<?php

namespace pizzashop\gateway\app\actions\Commande;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ConnectionAction permet de se connecter depuis l'api commande
 */
class ConnectionAction
{
    private Client $guzzle;

    public function __construct(Client $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        try {
            $authorizationHeader = $rq->getHeaderLine('Authorization');

            $data = $this->guzzle->request('POST', "/api/users/signin", [
                'headers' => [
                    'Authorization' => $authorizationHeader
                ]
            ]);
            $data = json_decode($data->getBody()->getContents(), true);

            $code = 200;
        } catch (GuzzleException $e) {
            if($e->getCode() == 401) {
                $code = 401;
                $data = [
                    "error" => "Email ou mot de passe incorrect",
                    "code" => $code
                ];
            }else {
                $data = [
                    "error" => $e->getMessage(),
                    "code" => $e->getCode()
                ];
                $code = 500;
            }
        }

        // retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}


