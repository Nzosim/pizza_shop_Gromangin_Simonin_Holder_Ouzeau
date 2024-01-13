<?php


namespace pizzashop\gateway\app\actions\Auth;

use GuzzleHttp\Client;
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
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        try {
            $body = file_get_contents("php://input");

            $this->guzzle->request('POST', "/api/users/signup", [
                'json' => json_decode($body, true)
            ]);
            $data = [];
            $code = 201;
        } catch (GuzzleException $e) {
            if($e->getCode() === 409) {
                $code = 409;
                $data = [
                    "error" => "Compte déjà existant avec cet email",
                    "code" => $code
                ];
            }else {
                $data = [
                    "error" => $e->getMessage(),
                    "code" => $e->getCode()
                ];
                $code = 500;
            }
        }

        // retourne les produits
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

