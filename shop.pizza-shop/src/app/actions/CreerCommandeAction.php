<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Item;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

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
        $commande = new CommandeDTO($data["mail_client"], $data["type_livraison"]);
        //Ajout des items
        foreach ($data["items"] as $nitem) {
            $itemDTO = Item::where("numero", "=", $nitem["numero"])->firstOrFail();
            $commande->addItem($itemDTO->toDTO());
        }
        try {
            $cdto = $this->container->get('commande.service')->creerCommande($commande);
            $url = "http://localhost:2080/api/commandes/" . $cdto->id;
            header('Location: ' . $url);
        } catch (HttpBadRequestException $e) {
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

