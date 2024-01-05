<?php

namespace pizzashop\gateway\app\actions\Commande;

use pizzashop\gateway\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CreerCommandeAction permet de créer une commande
 */
class CreerCommandeAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args)
    {

        // retour de la réponse
        return JSONRenderer::render($rs, 200, [])
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST' )
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Type', 'application/json');
    }
}

