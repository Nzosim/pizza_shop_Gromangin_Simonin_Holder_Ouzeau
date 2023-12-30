<?php

use pizzashop\auth\api\app\actions\RefreshTokenUserAction;
use pizzashop\auth\api\app\actions\SigninUserAction;
use pizzashop\auth\api\app\actions\SignupUserAction;
use pizzashop\auth\api\app\actions\ValidateUserAction;
use Psr\Container\ContainerInterface;

return [
    'users.signin' => function (ContainerInterface $c) {
        return new SigninUserAction($c);
    },
    'users.validate' => function (ContainerInterface $c) {
        return new ValidateUserAction($c);
    },
    'users.refresh' => function (ContainerInterface $c) {
        return new RefreshTokenUserAction($c);
    },
    'users.signup' => function (ContainerInterface $c) {
        return new SignupUserAction($c);
    },
];
