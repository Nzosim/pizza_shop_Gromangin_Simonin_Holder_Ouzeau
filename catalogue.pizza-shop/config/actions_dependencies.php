<?php

use pizzashop\catalogue\app\actions\GetAllProduitsAction;
use pizzashop\catalogue\app\actions\GetProduitByCategorieAction;
use pizzashop\catalogue\app\actions\GetProduitByIdAction;
use Psr\Container\ContainerInterface;

return [
    'produit.getall' => function (ContainerInterface $c) {
        return new GetAllProduitsAction($c);
    },
    'produit.getbyid' => function (ContainerInterface $c) {
        return new GetProduitByIdAction($c);
    },
    'produit.getbycategorie' => function (ContainerInterface $c) {
        return new GetProduitByCategorieAction($c);
    }
];
