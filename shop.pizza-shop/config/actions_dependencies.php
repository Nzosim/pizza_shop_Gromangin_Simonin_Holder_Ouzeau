<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\ConnectionAction;
use pizzashop\shop\app\actions\CreerCommandeAction;
use pizzashop\shop\app\actions\GetAllProduitsAction;
use pizzashop\shop\app\actions\GetProduitByCategorieAction;
use pizzashop\shop\app\actions\GetProduitByIdAction;
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
        return new CreerCommandeAction($c);
    },
    'commande.auth' => function () {
        return new ConnectionAction();
    },
    'produit.getall' => function (ContainerInterface $c) {
        return new GetAllProduitsAction($c);
    },
    'produit.getbyid' => function (ContainerInterface $c) {
        return new GetProduitByIdAction($c);
    },
    'produit.getbycategorie' => function (ContainerInterface $c) {
        return new GetProduitByCategorieAction($c);
    },
];
