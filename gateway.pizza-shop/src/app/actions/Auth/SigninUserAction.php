<?php


namespace pizzashop\gateway\app\actions\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * action qui permet de connecter un utilisateur
 */
class SigninUserAction
{
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        try {
            $authorizationHeader = $rq->getHeaderLine('Authorization');

            $data = $this->guzzle->request('POST', "/api/users/signin", [
                'headers' => [
                    'Authorization' => $authorizationHeader
                ]
            ]);
            $data = json_decode($data->getBody()->getContents(), true);
            $code = 200;
        } catch (GuzzleException $e) {
            if($e->getCode() == 401) {
                $code = 401;
                $data = [
                    "message" => "401 Unauthorized",
                    "exception" => [[
                        "type" => "Slim\\Exception\\HttpUnauthorizedException",
                        "message" => "Email ou mot de passe incorrect",
                        "code" => $e->getCode(),
                        "file" => $e->getFile(),
                        "line" => $e->getLine(),
                    ]]
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

