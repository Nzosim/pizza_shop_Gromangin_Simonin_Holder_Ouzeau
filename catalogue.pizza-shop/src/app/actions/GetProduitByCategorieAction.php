<?php

namespace pizzashop\catalogue\app\actions;

use pizzashop\catalogue\app\renderer\JSONRenderer;
use pizzashop\catalogue\domain\service\exception\CategorieNotFoundException;
use pizzashop\catalogue\domain\service\exception\IdCategorieManquantException;
use pizzashop\catalogue\domain\service\exception\IdManquantException;
use pizzashop\catalogue\domain\service\exception\ServiceProduitNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetProduitByCategorieAction permet d'obtenir les produits d'une catégorie
 */
class GetProduitByCategorieAction
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
            if (is_null($id)) throw new IdCategorieManquantException();

            $data = $this->container->get('product.service')->getProduitByCategorie($id);
            $code = 200;

            $retour = [];
            foreach ($data as $key => $value) {
                $retour[$key]['numero_produit'] = $value->numero_produit;
                $retour[$key]['libelle_produit'] = $value->libelle_produit;
                $retour[$key]['libelle_categorie'] = $value->libelle_categorie;
                $retour[$key]['URI'] = $value->URI;
            }
            $data = $retour;
        } catch (CategorieNotFoundException $e) {
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

        // retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

