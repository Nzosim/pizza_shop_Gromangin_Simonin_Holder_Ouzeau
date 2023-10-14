<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\app\renderer\JSONRenderer;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ValidateUserAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $token = $rq->getHeaderLine('Authorization');
        $token = explode(' ', $token);

        try {
            $connexion = $this->container->get('auth.service')->refresh($token[1]);

            $data = [
                'access_token' => $connexion['access_token'],
                'refresh_token' => $connexion['refresh_token']
            ];

        }catch(TokenExpirerException | TokenIncorrectException $e){
            $data = [
                "message" => "401 Unauthorized",
                "exception" => [[
                    "type" => "Slim\\Exception\\HttpUnauthorizedException",
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 401;
        }

        return JSONRenderer::render($rs, 200, $data);
    }
}

