<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
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
    'commande.create' => function () {
        return new CreerCommandeAction();
    }
];
