<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvialideException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SebastianBergmann\Diff\Exception;

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
        $commande = new CommandeDTO($data["mail_client"],$data["type_livraison"]);
        $commande->items = $data["items"];

        try {
            $cdto = $this->container->get('commande.service')->creerCommande($commande);
            $url = "http://localhost:2080/api/commandes/" . $cdto->id;
            // ajouter un code 201
            header('Location: ' . $url);
            $rs = $rs->withStatus(201);
        } catch (ServiceCommandeInvialideException $e) {
            $retour = [
                "message" => "400 Bad Request",
                "exception" => [[
                    "type" => "Slim\\Exception\\HttpBadRequestException",
                    "code" => 400,
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 404;
        } catch (\Exception $e) {
            $retour = [
                "message" => "500 Internal Server Error",
                "exception" => [[
                    "type" => "Exception",
                    "code" => 500,
                    "message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
        }

        return JSONRenderer::render($rs, $code, $retour);
    }
}

