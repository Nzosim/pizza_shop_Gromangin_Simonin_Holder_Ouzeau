<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

/**
 * Class AccederCommandeAction permet d'accéder à une commande
 */
class AccederCommandeAction
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

        try {
            // récupération de la commande
            $commande = $this->container->get('commande.service')->accederCommande($id);

            // construction de la réponse
            $data = [
                'type' => 'ressource',
                'commande' => $commande,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('commande', ['id' => $commande->id])],
                    'valider' => ['href' => $routeParser->urlFor('valider_commande', ['id' => $commande->id])],
                ]
            ];
            $code = 200;
        } catch (ServiceCommandeNotFoundException $e) {
            // si la commande n'est pas trouvée, on lève une exception
            $data = [
                "message" => "404 Not Found",
                "exception" => [[
                    "type" => "Slim\\Exception\\HttpNotFoundException",
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            $code = 404;
        }

        // retour de la réponse
        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

