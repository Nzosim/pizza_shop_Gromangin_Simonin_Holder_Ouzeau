<?php

namespace pizzashop\gateway\app\actions\Auth;

use GuzzleHttp\Exception\GuzzleException;
use pizzashop\gateway\app\renderer\GuzzleRequest;
use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * action qui permet de valider un token
 */
class ValidateUserAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        try {
            $authorizationHeader = $rq->getHeaderLine('Authorization');

            $data = GuzzleRequest::MakeRequest('GET', 'auth', "users/validate", false, $authorizationHeader);
            $code = 200;
        } catch (\Exception $e) {
            if($e->getCode() == 401) {

                $code = 401;
                $data = [
                    "message" => "401 Unauthorized",
                    "exception" => [[
                        "type" => "Slim\\Exception\\HttpUnauthorizedException",
                        "message" => "Token invalide ou expiré",
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
        // on retourne la réponse avec le code et les données
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

