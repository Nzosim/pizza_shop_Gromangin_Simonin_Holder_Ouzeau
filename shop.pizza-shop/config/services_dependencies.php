<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'commande.logger' => function (ContainerInterface $c) {
        $log = new Logger($c->get('logger.commande.name'));
        return $log->pushHandler(new Streamhandler($c->get('log.commande.file'), $c->get('log.commande.level')));
    },
    'commande.service' => function (ContainerInterface $c) {
        return new ServiceCommande($c->get('commande.logger'));
    },
];
