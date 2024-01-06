<?php

namespace pizzashop\gateway\app\actions\Commande;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ValiderCommandeAction permet de valider une commande
 */
class ValiderCommandeAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $data = GuzzleRequest::MakeRequest('POST', 'commande', "commandes/" . $args['id']);
            $code = 200;
        } catch (GuzzleException $e) {
            $data = [
                "error" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            $code = 500;
        }

        // retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}