<?php

namespace pizzashop\gateway\app\actions\Catalogue;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetProduitByCategorieAction permet d'obtenir les produits d'une catégorie
 */
class GetProduitByCategorieAction
{
    private string $guzzle;

    public function __construct(string $container)
    {
        $this->guzzle = $container;
    }
    
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        try {
            $uri = $this->guzzle . ":41216/api/categories/" . $args['id'] . "/produits";
            $data = GuzzleRequest::MakeRequest('GET', $uri);
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
            ->withHeader('Access-Control-Allow-Methods', 'GET' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

