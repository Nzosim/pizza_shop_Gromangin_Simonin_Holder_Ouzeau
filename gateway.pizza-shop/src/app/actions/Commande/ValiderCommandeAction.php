<?php

namespace pizzashop\gateway\app\actions\Commande;

use GuzzleHttp\Client;
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
    private Client $guzzle;

    public function __construct(Client $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $data = $this->guzzle->request('PATCH', "/api/commandes/" . $args['id']);
            $data = json_decode($data->getBody()->getContents(), true);
            $code = 200;
        } catch (GuzzleException $e) {
            if($e->getCode() == 404) {
                $data = [
                    "error" => "Commande introuvable",
                    "code" => $e->getCode()
                ];
                $code = 404;
            } else if($e->getCode() == 400) {
                $data = [
                    "error" => "Commande déjà validée",
                    "code" => $e->getCode()
                ];
                $code = 500;
            } else {
                $data = [
                    "error" => $e->getMessage(),
                    "code" => $e->getCode()
                ];
                $code = 500;
            }
        }

        // Retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}
