<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
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

        return JSONRenderer::render($rs, $code, $data)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json');
    }
}

