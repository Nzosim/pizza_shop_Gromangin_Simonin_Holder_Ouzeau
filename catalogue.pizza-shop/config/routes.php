<?php
declare(strict_types=1);

use Slim\App;

return function (App $app): void {

    $app->get('/produits[/]', $app->getContainer()->get('produit.getall'))
        ->setName('produits');

    $app->get('/produits/{id}[/]', $app->getContainer()->get('produit.getbyid'))
        ->setName('produit');

    $app->get('/categories/{id}/produits[/]', $app->getContainer()->get('produit.getbycategorie'))
        ->setName('produits_categorie');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
};