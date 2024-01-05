<?php

namespace pizzashop\config;

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
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

$capsule = new Manager();
$capsule->addConnection(parse_ini_file(__DIR__ . '/commande.db.ini'), 'commande');
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $app;