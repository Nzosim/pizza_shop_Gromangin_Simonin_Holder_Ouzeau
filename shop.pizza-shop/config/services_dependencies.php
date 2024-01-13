<?php

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'commande.logger' => function (ContainerInterface $c) {
        $log = new Logger($c->get('logger.commande.name'));
        return $log->pushHandler(new Streamhandler($c->get('log.commande.file'), $c->get('log.commande.level')));
    },
    'auth.client' => function (ContainerInterface $c) {
        return new Client([
            'base_uri' => $c->get('auth_base_uri'),
            'timeout' => 10.0,
        ]);
    },
    'catalogue.client' => function (ContainerInterface $c) {
        return new Client([
            'base_uri' => $c->get('catalogue_base_uri'),
            'timeout' => 10.0,
        ]);
    },
    'commande.client' => function (ContainerInterface $c) {
        return new Client([
            'base_uri' => $c->get('commande_base_uri'),
            'timeout' => 10.0,
        ]);
    },
    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('commande.logger'), $c->get('catalogue.client'));
    },
];
