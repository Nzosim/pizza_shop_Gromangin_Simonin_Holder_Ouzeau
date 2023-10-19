<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerCommandeAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        //Récupération du json
        $data = json_decode(file_get_contents('php://input'), true);
        //Création de la commande DTO à partir du json
        $commande=new CommandeDTO($data["mail_client"],$data["type_livraison"]);
        //Ajout des items
        foreach ($data["items"] as $nitem) {
            $p = Produit::where("numero", "=", $nitem["numero"])->firstOrFail();
            $item = new Item();
            $prod = $p->toDTO($nitem["taille"]);
            $item->taille = $nitem["taille"];
            $item->numero = $prod->numero_produit;
            $item->libelle = $prod->libelle_produit;
            $item->tarif = $prod->tarif;
            $item->quantite = $nitem["quantite"];
            $item->libelle_taille = $prod->libelle_taille;
            $item->commande_id = $commande->id;
            $item->save();
        }
        $cdto = $commande->toDTO();
        try {
            $cdto = $this->container->get('commande.service')->creerCommande($cdto);
            $url = "http://localhost:2080/api/commandes/" . $cdto->id;
            header('Location: ' . $url);
        } catch
        (HttpBadRequestException $e) {
            $retour = [
                "message" => "400 Bad Request",
                "exception" => [[
                    "type" => "Slim\\Exception\\HttpBadRequestException",
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 404;

            return JSONRenderer::render($rs, $code, $retour);
        }
    }
}

