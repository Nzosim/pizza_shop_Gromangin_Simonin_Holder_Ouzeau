<?php


namespace pizzashop\gateway\app\actions\Auth;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * action qui permet de créer un utilisateur
 */
class SignupUserAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // TODO prb avec guzzle qui ne récupère pas le body de la requête
        try {
            $body = $rq->getBody()->getContents();
            echo "body: $body";
            $data = GuzzleRequest::MakeRequest('POST', 'auth', "users/signup", $body);
            $code = 200;
        } catch (GuzzleException $e) {
            $data = [
                "error" => $e->getMessage(),
                "code" => $e->getCode()
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

