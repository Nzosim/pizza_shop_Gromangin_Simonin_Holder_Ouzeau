<?php

namespace pizzashop\config;

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$settings = require_once __DIR__ . '/settings.php';
$dependencies = require_once __DIR__ . '/services_dependencies.php';
$actions = require_once __DIR__ . '/actions_dependencies.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($settings);
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