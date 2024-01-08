<?php

namespace pizzashop\gateway\app\actions\Commande;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ConnectionAction permet de se connecter depuis l'api commande
 */
class ConnectionAction
{
    private string $guzzle;

    public function __construct(string $container)
    {
        $this->guzzle = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        try {
            //TODO prb avec guzzle qui récupère le body mais ne l'envoi pas à l'api
            $authorizationHeader = $rq->getHeaderLine('Authorization');


            $uri = $this->guzzle . ":41215/api/connection";
            $data = GuzzleRequest::MakeRequest('POST', $uri, false, $authorizationHeader);
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


