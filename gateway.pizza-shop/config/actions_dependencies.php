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

return [
    // Commande actions
    'commande.access' => function () {
        return new AccederCommandeAction();
    },
    'commande.validate' => function () {
        return new ValiderCommandeAction();
    },
    'commande.create' => function () {
        return new CreerCommandeAction();
    },
    'commande.auth' => function () {
        return new ConnectionAction();
    },

    // Catalogue action
    'produit.getall' => function () {
        return new GetAllProduitsAction();
    },
    'produit.getbyid' => function () {
        return new GetProduitByIdAction();
    },
    'produit.getbycategorie' => function () {
        return new GetProduitByCategorieAction();
    },

    // Auth action
    'users.signin' => function () {
        return new SigninUserAction();
    },
    'users.validate' => function () {
        return new ValidateUserAction();
    },
    'users.refresh' => function () {
        return new RefreshTokenUserAction();
    },
    'users.signup' => function () {
        return new SignupUserAction();
    }
];
