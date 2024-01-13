<?php

namespace pizzashop\gateway\app\actions\Catalogue;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetProduitByIdAction permet d'obtenir un produit par son id
 */
class GetProduitByIdAction
{
    private Client $guzzle;

    public function __construct(Client $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        try {
            $data = $this->guzzle->request('GET', "/api/produits/" . $args['id']);
            $data = json_decode($data->getBody()->getContents(), true);
            $code = 200;
        } catch (GuzzleException $e) {
            if($e->getCode() === 404) {
                $code = 404;
                $data = [
                    "error" => "Produit introuvable",
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
            ->withHeader('Access-Control-Allow-Methods', 'GET' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

