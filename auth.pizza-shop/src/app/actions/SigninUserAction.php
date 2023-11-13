<?php


namespace pizzashop\auth\api\app\actions;


use pizzashop\auth\api\app\renderer\JSONRenderer;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SigninUserAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        $authorizationHeader = $rq->getHeaderLine('Authorization');
        $authorizationHeader = explode(' ', $authorizationHeader);
        $authorizationHeader = base64_decode($authorizationHeader[1]);
        $authorizationHeader = explode(':', $authorizationHeader);

        try {
            $connexion = $this->container->get('auth.service')->signin($authorizationHeader[0], $authorizationHeader[1]);

            $data = [
                'access_token' => $connexion['access_token'],
                'refresh_token' => $connexion['refresh_token']
            ];
            $code = 200;

        } catch (EmailOuMotDePasseIncorrectException $e) {
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

        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json');
    }
}

