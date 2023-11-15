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
};