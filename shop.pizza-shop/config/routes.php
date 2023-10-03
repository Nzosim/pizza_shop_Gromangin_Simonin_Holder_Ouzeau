<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\CreerCommandeAction;
use Slim\App;

return function (App $app): void {

    $app->post('/commandes[/]', CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id}[/]', AccederCommandeAction::class)
        ->setName('commande');
    $app->patch('/commandes/{id}[/]', ValiderCommandeAction::class)
        ->setName('valider_commande');
};