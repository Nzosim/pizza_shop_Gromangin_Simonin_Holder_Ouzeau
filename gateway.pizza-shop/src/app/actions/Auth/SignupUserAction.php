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
    private string $guzzle;

    public function __construct(string $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        try {
            $body = file_get_contents("php://input");
            $uri = $this->guzzle . ':41217/api/users/signup';
//            echo $body;
            $data = GuzzleRequest::MakeRequest('POST', $uri, json_decode($body, true));
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

