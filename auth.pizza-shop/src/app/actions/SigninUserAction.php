<?php


namespace pizzashop\auth\api\app\actions;


use pizzashop\auth\api\app\renderer\JSONRenderer;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * action qui permet de connecter un utilisateur
 */
class SigninUserAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // récupération du token donné indiqué dans le header de la requête
        $authorizationHeader = $rq->getHeaderLine('Authorization');
        $authorizationHeader = explode(' ', $authorizationHeader);
        // on décode le token
        $authorizationHeader = base64_decode($authorizationHeader[1]);
        $authorizationHeader = explode(':', $authorizationHeader);

        try {
            // on tente de connecter l'utilisateur
            $connexion = $this->container->get('auth.service')->signin($authorizationHeader[0], $authorizationHeader[1]);

            // si le token est valide, on retourne un code 200 et le token
            $data = [
                'access_token' => $connexion['access_token'],
                'refresh_token' => $connexion['refresh_token']
            ];
            $code = 200;

        } catch (EmailOuMotDePasseIncorrectException $e) {
            // si les credentials sont incorrects, on retourne un code 401 et un message d'erreur
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

        // on retourne la réponse avec le code et les données
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

