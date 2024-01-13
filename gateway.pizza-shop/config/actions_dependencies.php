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
        return new AccederCommandeAction($c->get('commande.client'));
    },
    'commande.validate' => function (ContainerInterface $c) {
        return new ValiderCommandeAction($c->get('commande.client'));
    },
    'commande.create' => function (ContainerInterface $c) {
        return new CreerCommandeAction($c->get('commande.client'));
    },
    'commande.auth' => function (ContainerInterface $c) {
        return new ConnectionAction($c->get('auth.client'));
    },

    // Catalogue action
    'produit.getall' => function (ContainerInterface $c) {
        return new GetAllProduitsAction($c->get('catalogue.client'));
    },
    'produit.getbyid' => function (ContainerInterface $c) {
        return new GetProduitByIdAction($c->get('catalogue.client'));
    },
    'produit.getbycategorie' => function (ContainerInterface $c) {
        return new GetProduitByCategorieAction($c->get('catalogue.client'));
    },

    // Auth action
    'users.signin' => function (ContainerInterface $c) {
        return new SigninUserAction($c->get('auth.client'));
    },
    'users.validate' => function (ContainerInterface $c) {
        return new ValidateUserAction($c->get('auth.client'));
    },
    'users.refresh' => function (ContainerInterface $c) {
        return new RefreshTokenUserAction($c->get('auth.client'));
    },
    'users.signup' => function (ContainerInterface $c) {
        return new SignupUserAction($c->get('auth.client'));
    }
];
