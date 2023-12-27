<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\CreerCommandeAction;
use Slim\App;

return function (App $app): void {

    $app->post('/commandes[/]', CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id}[/]', $app->getContainer()->get('commande.access'))
        ->setName('commande');
    $app->patch('/commandes/{id}[/]', $app->getContainer()->get('commande.validate'))
        ->setName('valider_commande');

    $app->post('/connection[/]', $app->getContainer()->get('commande.auth'))
        ->setName('connection');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->get('/produits[/]', $app->getContainer()->get('produit.getall'))
        ->setName('produits');

    $app->get('/produits/{id}[/]', $app->getContainer()->get('produit.getbyid'))
        ->setName('produit');

    $app->get('/categories/{id}/produits[/]', $app->getContainer()->get('produit.getbycategorie'))
        ->setName('produits_categorie');
};