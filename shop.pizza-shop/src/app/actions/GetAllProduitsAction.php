<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetAllProduitsAction permet d'obtenir tous les produits
 */
class GetAllProduitsAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // récupération de tous les produits
        try {
            $data = $this->container->get('product.service')->getAllProduits();
            $code = 200;

            $retour = [];
            foreach ($data as $key => $value) {
                $retour[$key]['numero_produit'] = $value->numero_produit;
                $retour[$key]['libelle_produit'] = $value->libelle_produit;
                $retour[$key]['libelle_categorie'] = $value->libelle_categorie;
                $retour[$key]['URI'] = $value->URI;
            }
            $data = $retour;

        } catch (\Exception $e) {
            // sinon on retourne une exception
            $data = [
                "message" => "500 Internal Server Error",
                "exception" => [[
                    "type" => "Exception",
                    "code" => 500,
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
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

