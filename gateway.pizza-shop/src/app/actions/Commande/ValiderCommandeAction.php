<?php

namespace pizzashop\gateway\app\actions\Commande;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ValiderCommandeAction permet de valider une commande
 */
class ValiderCommandeAction
{
    private string $guzzle;

    public function __construct(string $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $uri = $this->guzzle . ":41215/api/commandes/" . $args['id'];
            $data = GuzzleRequest::MakeRequest('PATCH', $uri);
            $code = 200;
        } catch (GuzzleException $e) {
            // On récupère la réponse associée à l'exception s'il y en a une
            $response = $e->hasResponse() ? $e->getResponse() : null;

            if ($response !== null) {
                // On récupère le code de statut de la réponse et le message JSON
                $statusCode = $response->getStatusCode();
                $message = json_decode($response->getBody(), true);

                // On gère le cas où le code de statut est 400 et qu'il y a une clé 'exception' dans le message
                if ($statusCode === 400 && isset($message['exception'])) {
                    foreach ($message['exception'] as $exception) {
                        // On vérifie si le message indique que la commande est déjà validée
                        if (strpos($exception['message'], 'La commande') !== false && strpos($exception['message'], 'est déjà validée') !== false) {
                            $code = 400; // Utiliser le code de statut 400
                            $data = [
                                "error" => "La commande est déjà validée.",
                                "code" => $code
                            ];
                            break; // Sortir de la boucle dès qu'on trouve le message souhaité
                        }
                    }
                } else {
                    // On utilise le code de statut et le message d'erreur par défaut
                    $code = $statusCode;
                    $data = [
                        "error" => $e->getMessage(),
                        "code" => $e->getCode()
                    ];
                }
            }
        } catch (\Exception $e) {
            // On gère les autres exceptions
            $code = 500;
            $data = [
                "error" => $e->getMessage(),
                "code" => $e->getCode()
            ];
        }

        // Retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}
