<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\ConnectionAction;
use pizzashop\shop\app\actions\CreerCommandeAction;
use pizzashop\shop\app\actions\ValiderCommandeAction;
use Psr\Container\ContainerInterface;

return [
    'commande.access' => function (ContainerInterface $c) {
        return new AccederCommandeAction($c);
    },
    'commande.validate' => function (ContainerInterface $c) {
        return new ValiderCommandeAction($c);
    },
    'commande.create' => function (ContainerInterface $c) {
        return new CreerCommandeAction($c, $c->get('guzzle.base_uri'));
    },
    'commande.auth' => function (ContainerInterface $c) {
        return new ConnectionAction($c->get('guzzle.base_uri'));
    }
];
