<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

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
        $id = $args['id'] ?? null;
        if (is_null($id)) throw new HttpBadRequestException($rq, 'id commande manquant');

        $routeParser = RouteContext::fromRequest($rq)->getRouteParser();

        try {
            $commande = $this->container->get('commande.service')->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            $error = [
                'message' => '404 Not Found',
                'exception' => [[
                    "type" => "Slim\\Exception\\HttpNotFoundException",
                    "code" => 404,
                    "message" => "Commande $id not found",
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                ]]
            ];
            return JSONRenderer::render($rs, 404, $error);
        }

        $commande_data = [
            'type' => 'ressource',
            'commande' => $commande,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('commande', ['id' => $commande->id])],
                'valider' => ['href' => $routeParser->urlFor('valider_commande', ['id' => $commande->id])],
            ]
        ];

        return JSONRenderer::render($rs, 200, $commande_data);

    }
}

