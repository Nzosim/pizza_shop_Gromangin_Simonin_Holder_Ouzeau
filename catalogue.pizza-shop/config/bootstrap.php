<?php

namespace pizzashop\config;

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
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

$capsule = new Manager();
$capsule->addConnection(parse_ini_file(__DIR__ . '/catalog.db.ini'), 'catalog');
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $app;