<?php

namespace pizzashop\catalogue\app\actions;

use pizzashop\catalogue\app\renderer\JSONRenderer;
use pizzashop\catalogue\domain\service\exception\IdManquantException;
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
        $id = $args['id'] ?? null;

        // récupération de tous les produits
        try {
            if (is_null($id)) throw new IdManquantException();

            $data = $this->container->get('product.service')->getProduitById($id);

            $tailles = [];

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
        }catch (IdManquantException $e) {
            // si il manque l'id en paramètre, on lève une exception
            $data = [
                "message" => "400 Bad Request",
                "exception" => [[
                    "type" => "Exception",
                    "code" => 400,
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 400;
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

