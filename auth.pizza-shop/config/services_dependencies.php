<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\auth\api\domain\auth\AuthProvider;
use pizzashop\auth\api\domain\auth\ManagerJWT;
use pizzashop\auth\api\domain\services\ServiceAuth;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'auth.provider' => function () {
        return new AuthProvider();
    },
    'auth.managerJWT' => function (ContainerInterface $c) {
        return new ManagerJWT($c->get('auth.secret'), $c->get('auth.time'));
    },
    'auth.service' => function (ContainerInterface $c) {
        return new ServiceAuth($c->get('auth.provider'), $c->get('auth.managerJWT'));
    },
];
