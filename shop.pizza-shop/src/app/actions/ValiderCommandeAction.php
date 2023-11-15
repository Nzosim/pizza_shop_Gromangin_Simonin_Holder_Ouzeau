<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvalidTransitionException;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SebastianBergmann\Diff\Exception;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

/**
 * Class ValiderCommandeAction permet de valider une commande
 */
class ValiderCommandeAction
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // récupération de l'id de la commande
        $id = $args['id'] ?? null;
        // si l'id est null, on lève une exception
        if (is_null($id)) throw new HttpBadRequestException($rq, 'id commande manquant');

        $routeParser = RouteContext::fromRequest($rq)->getRouteParser();

        $error = array(
            'message' => '',
            'type' => '',
        );
        $exception = null;
        $code = 200;

        try {
            // validation de la commande
            $this->container->get('commande.service')->validationCommande($id);
            $commande = $this->container->get('commande.service')->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            // si la commande n'est pas trouvée, on lève une exception
            $error["message"] = "404 Not Found";
            $error["type"] = "Slim\\Exception\\HttpNotFoundException";
            $code = 404;
            $exception = $e;
        } catch (ServiceCommandeInvalidTransitionException $e) {
            // si la requête est invalide, on lève une exception
            $error["message"] = "400 Bad Request";
            $error["type"] = "Slim\\Exception\\HttpBadRequestException";
            $code = 400;
            $exception = $e;
        } catch (Exception $e) {
            // si une erreur interne se produit, on lève une exception
            $error["message"] = "500 Internal Server Error";
            $error["type"] = "Exception";
            $code = 500;
            $exception = $e;
        }

        // construction de la réponse
        if ($exception == null) {
            $data = [
                'type' => 'ressource',
                'commande' => $commande,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('commande', ['id' => $commande->id])],
                    'valider' => ['href' => $routeParser->urlFor('valider_commande', ['id' => $commande->id])],
                ]
            ];
        } else {
            $data = [
                "message" => $error["message"],
                "exception" => [[
                    "type" => $error["type"],
                    "message" => $exception->getMessage(),
                    "code" => $exception->getCode(),
                    "file" => $exception->getFile(),
                    "line" => $exception->getLine(),
                ]]
            ];
        }

        // retour de la réponse
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'PATCH' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}