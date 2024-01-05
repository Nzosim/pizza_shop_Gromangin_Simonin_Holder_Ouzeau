<?php

namespace pizzashop\shop\app\actions;

use GuzzleHttp\Client;
use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvialideException;
use pizzashop\shop\domain\service\exception\TokenInexistantException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CreerCommandeAction permet de créer une commande
 */
class CreerCommandeAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // création du client guzzle
        $client = new Client([
            'base_uri' => 'http://docketu.iutnc.univ-lorraine.fr:43225/api/users/',
            'timeout' => 10.0,
        ]);

        try {
            // récupération du header Authorization
            $authorizationHeader = $rq->getHeaderLine('Authorization');
            // si le header est vide, on lève une exception
            if (!$authorizationHeader) throw new TokenInexistantException();

            // requête vers l'api users
            $response = $client->request('GET', 'validate', [
                'headers' => [
                    'Authorization' => $authorizationHeader
                ]
            ]);
            $retour = [];
            $dataUser = json_decode($response->getBody());
            // si l'utilisateur n'est pas connecté, on retourne une exception
            if (!property_exists($dataUser, 'user')) {
                $retour = $dataUser;
                $code = 401;
            } else {
                // sinon on créer la commande
                $data = json_decode(file_get_contents('php://input'), true);
                //Création de la commande DTO à partir du json
                $commande = new CommandeDTO($dataUser->user->email, $data["type_livraison"]);
                $commande->items = $data["items"];

                // création de la commande
                $cdto = $this->container->get('commande.service')->creerCommande($commande);

                // redirection vers la commande
                $url = "http://docketu.iutnc.univ-lorraine.fr:43220/api/commandes/" . $cdto->id;
                $code = 200;
                header('Location: ' . $url);
                $rs = $rs->withStatus(201);
            }
        } catch (ServiceCommandeInvialideException $e) {
            // si la commande est invalide, on retourne une exception
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
            $code = 400;
        } catch (\Exception $e) {
            // sinon on retourne une exception
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
            $code = 500;
        }

        // retour de la réponse
        return JSONRenderer::render($rs, $code, $retour)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

