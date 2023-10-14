<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\auth\api\domain\services\ServiceAuth;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use pizzashop\shop\domain\service\commande\ServiceCommande;
use Psr\Container\ContainerInterface;

return [
    'auth.service' => function () {
        return new ServiceAuth();
    },
];
