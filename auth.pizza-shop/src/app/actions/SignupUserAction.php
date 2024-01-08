<?php


namespace pizzashop\auth\api\app\actions;


use pizzashop\auth\api\app\renderer\JSONRenderer;
use pizzashop\auth\api\exceptions\CompteDejaExistant;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * action qui permet de créer un utilisateur
 */
class SignupUserAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {
        // récupération du du mot de passe de l'email et du nom donné indiqué dans le body de la requête
        $body = $rq->getParsedBody();
        $password = $body['password'];

        // encodage du mot de passe
        $password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // on tente de connecter l'utilisateur
            $this->container->get('auth.service')->signup($body['email'], $password, $body['username']);

            $data = [
                "Compté créé, vous pouvez vous connecter"
            ];
            $code = 200;
        } catch(CompteDejaExistant $e) {
            $data = [
                "message" => "ERROR",
                "exception" => [[
                    "type" => "pizzashop\\auth\\api\\exceptions\\CompteDejaExistant",
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 409;
        } catch (\Exception $e) {
            $data = [
                "message" => "ERROR",
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

