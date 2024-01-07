<?php


namespace pizzashop\gateway\app\actions\Auth;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/*
 * action qui permet de refresh le token d'un utilisateur
 */
class RefreshTokenUserAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
           
            $authorizationHeader = $rq->getHeaderLine('Authorization');

            
            $data = GuzzleRequest::MakeRequest('POST', 'auth', "users/refresh", false, $authorizationHeader);
            $code = 200; 
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

         // on retourne la réponse avec le code et les données
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

