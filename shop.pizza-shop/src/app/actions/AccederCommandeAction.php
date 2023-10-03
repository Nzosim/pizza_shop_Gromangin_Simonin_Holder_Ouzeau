<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class AccederCommandeAction
{
    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'] ?? null;
        if (is_null($id)) throw new HttpBadRequestException($rq, 'id commande manquant');
        try {
            $commande = $this->container->get('commande.service')->accederCommande($id);
        } catch (ServiceCommandeNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }

        $routeParser = RouteContext::fromRequest($rq)->getRouteParser();
        $commande_data = [
            'type' => 'ressourse',
            'commande' => $commande,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('commande', ['id' => $commande->id])],
                'valider' => ['href' => $routeParser->urlFor('valider_commande', ['id' => $commande->id])],
            ]
        ];
        return JSONRenderer::render($rs, 200, $commande_data);

    }
}

