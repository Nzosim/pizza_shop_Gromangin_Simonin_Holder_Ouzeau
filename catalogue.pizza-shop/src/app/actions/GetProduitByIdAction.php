<?php

namespace pizzashop\catalogue\app\actions;

use pizzashop\catalogue\app\renderer\JSONRenderer;
use pizzashop\catalogue\domain\service\exception\IdManquantException;
use pizzashop\catalogue\domain\service\exception\ServiceProduitNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetProduitByIdAction permet d'obtenir un produit par son id
 */
class GetProduitByIdAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {

        // récupération de l'id du produit en paramètre
        $id = $args['id'];

        // récupération de tous les produits
        try {
            $data = $this->container->get('product.service')->getProduitById($id);

            foreach ($data as $key => $value) {
                $tailles[$key]['id_taille'] = $value->id_taille;
                $tailles[$key]['libelle_taille'] = $value->libelle_taille;
                $tailles[$key]['tarif'] = $value->tarif;
            }

            $data = [
                "numero_produit" => $data[0]->numero_produit,
                "libelle_produit" => $data[0]->libelle_produit,
                "libelle_categorie" => $data[0]->libelle_categorie,
                "URI" => "/api/produits/10",
                "tailles" => $tailles,
            ];
            $code = 200;
        } catch (ServiceProduitNotFoundException $e) {
            $data = [
                "message" => "404 Not Found",
                "exception" => [[
                    "type" => "pizzashop\\catalogue\\domain\\service\\exception\\IdInexistantException",
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 404;
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

        // retourne le produit
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

