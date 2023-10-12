<?php

use pizzashop\auth\api\app\actions\RefreshTokenUserAction;
use pizzashop\auth\api\app\actions\SigninUserAction;
use pizzashop\auth\api\app\actions\ValidateUserAction;
use Psr\Container\ContainerInterface;

return [
    'users.signin' => function (ContainerInterface $c) {
        return new SigninUserAction($c);
    },
    'users.validate' => function () {
        return new ValidateUserAction();
    },
    'users.refresh' => function () {
        return new RefreshTokenUserAction();
    }
];
