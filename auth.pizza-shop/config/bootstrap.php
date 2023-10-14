<?php

namespace pizzashop\config;

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Eloquent;
use Slim\Factory\AppFactory;


$dependencies = require_once __DIR__ . '/services_dependencies.php';
$actions = require_once __DIR__ . '/actions_dependencies.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($dependencies);
$builder->addDefinitions($actions);
$c = $builder->build();
$app = AppFactory::createFromContainer($c);

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->setBasePath("/api");
$app->addErrorMiddleware(true, false, false);

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection(parse_ini_file(__DIR__ . '/auth.db.ini'), 'auth');
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $app;