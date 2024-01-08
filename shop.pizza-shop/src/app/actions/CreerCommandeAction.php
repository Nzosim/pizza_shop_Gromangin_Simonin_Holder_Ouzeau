<?php

namespace pizzashop\shop\app\actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
    private string $guzzleBaseUri;

    public function __construct(ContainerInterface $container, string $guzzleBaseUri)
    {
        $this->container = $container;
        $this->guzzleBaseUri = $guzzleBaseUri;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // création du client guzzle
        $client = new Client([
            'base_uri' => $this->guzzleBaseUri . ':41217/api/users/',
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
            $data = [];
            $dataUser = json_decode($response->getBody());
            // si l'utilisateur n'est pas connecté, on retourne une exception
            if (!property_exists($dataUser, 'user')) {
                $data = $dataUser;
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
                $url = $this->guzzleBaseUri . ":41215/api/commandes/" . $cdto->id;
                $code = 200;
                header('Location: ' . $url);
                $rs = $rs->withStatus(201);
            }
        } catch (ServiceCommandeInvialideException $e) {
            // si la commande est invalide, on retourne une exception
            $data = [
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

            if ($e instanceof GuzzleException) {
                // On récupére la réponse associée à l'exception s'il y en a une
                $response = $e->hasResponse() ? $e->getResponse() : null;

                if ($response !== null) {
                    // On récupére le code de statut de la réponse et le message JSON
                    $statusCode = $response->getStatusCode();
                    $message = json_decode($response->getBody(), true);

                    // on gére le cas où le code de statut est 401 et qu'il y a une clé 'exception' dans le message
                    if ($statusCode === 401 && isset($message['exception'])) {
                        $code = 401;
                        $data = $message;
                    } else {
                        // on utilise le code de statut et le message d'erreur par défaut
                        $code = $statusCode;
                        $data = [
                            "error" => $e->getMessage(),
                            "code" => $e->getCode()
                        ];
                    }
                }
            } else {
                // On gérer les autres exceptions
                $code = 500;
                $data = [
                    "error" => $e->getMessage(),
                    "code" => $e->getCode()
                ];
            }

        }

        // retour de la réponse
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

