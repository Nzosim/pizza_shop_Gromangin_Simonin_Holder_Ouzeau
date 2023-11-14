<?php

use pizzashop\auth\api\domain\auth\AuthProvider;
use pizzashop\auth\api\domain\auth\ManagerJWT;
use pizzashop\auth\api\domain\services\ServiceAuth;
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
