<?php

use pizzashop\gateway\app\actions\Auth\RefreshTokenUserAction;
use pizzashop\gateway\app\actions\Auth\SigninUserAction;
use pizzashop\gateway\app\actions\Auth\SignupUserAction;
use pizzashop\gateway\app\actions\Auth\ValidateUserAction;
use pizzashop\gateway\app\actions\Catalogue\GetAllProduitsAction;
use pizzashop\gateway\app\actions\Catalogue\GetProduitByCategorieAction;
use pizzashop\gateway\app\actions\Catalogue\GetProduitByIdAction;
use pizzashop\gateway\app\actions\Commande\AccederCommandeAction;
use pizzashop\gateway\app\actions\Commande\ConnectionAction;
use pizzashop\gateway\app\actions\Commande\CreerCommandeAction;
use pizzashop\gateway\app\actions\Commande\ValiderCommandeAction;
use Psr\Container\ContainerInterface;

return [
    // Commande actions
    'commande.access' => function (ContainerInterface $c) {
        return new AccederCommandeAction($c->get('guzzle.base_uri'));
    },
    'commande.validate' => function (ContainerInterface $c) {
        return new ValiderCommandeAction($c->get('guzzle.base_uri'));
    },
    'commande.create' => function (ContainerInterface $c) {
        return new CreerCommandeAction($c->get('guzzle.base_uri'));
    },
    'commande.auth' => function (ContainerInterface $c) {
        return new ConnectionAction($c->get('guzzle.base_uri'));
    },

    // Catalogue action
    'produit.getall' => function (ContainerInterface $c) {
        return new GetAllProduitsAction($c->get('guzzle.base_uri'));
    },
    'produit.getbyid' => function (ContainerInterface $c) {
        return new GetProduitByIdAction($c->get('guzzle.base_uri'));
    },
    'produit.getbycategorie' => function (ContainerInterface $c) {
        return new GetProduitByCategorieAction($c->get('guzzle.base_uri'));
    },

    // Auth action
    'users.signin' => function (ContainerInterface $c) {
        return new SigninUserAction($c->get('guzzle.base_uri'));
    },
    'users.validate' => function (ContainerInterface $c) {
        return new ValidateUserAction($c->get('guzzle.base_uri'));
    },
    'users.refresh' => function (ContainerInterface $c) {
        return new RefreshTokenUserAction($c->get('guzzle.base_uri'));
    },
    'users.signup' => function (ContainerInterface $c) {
        return new SignupUserAction($c->get('guzzle.base_uri'));
    }
];
