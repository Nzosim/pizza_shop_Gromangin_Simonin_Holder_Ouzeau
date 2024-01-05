<?php
declare(strict_types=1);

use Slim\App;

return function (App $app): void {

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    // Routes commandes
    $app->post('/commandes[/]', $app->getContainer()->get('commande.create'))
        ->setName('creer_commande');

    $app->get('/commandes/{id}[/]', $app->getContainer()->get('commande.access'))
        ->setName('commande_get');

    $app->patch('/commandes/{id}[/]', $app->getContainer()->get('commande.validate'))
        ->setName('valider_commande');

    $app->post('/connection[/]', $app->getContainer()->get('commande.auth'))
        ->setName('connection');

    // Routes catalogue
    $app->get('/produits[/]', $app->getContainer()->get('produit.getall'))
        ->setName('produits');

    $app->get('/produits/{id}[/]', $app->getContainer()->get('produit.getbyid'))
        ->setName('produit');

    $app->get('/categories/{id}/produits[/]', $app->getContainer()->get('produit.getbycategorie'))
        ->setName('produits_categorie');

    // Routes auth
    $app->post('/users/signin', $app->getContainer()->get('users.signin'))
        ->setName('signin');

    $app->get('/users/validate', $app->getContainer()->get('users.validate'))
        ->setName('validite');

    $app->post('/users/refresh', $app->getContainer()->get('users.refresh'))
        ->setName('refresh_token');

    $app->post('/users/signup', $app->getContainer()->get('users.signup'))
        ->setName('signup');
};