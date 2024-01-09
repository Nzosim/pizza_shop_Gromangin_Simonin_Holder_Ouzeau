<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

return [
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
];