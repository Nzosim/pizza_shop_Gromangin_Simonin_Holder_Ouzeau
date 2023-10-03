<?php

namespace pizzashop\config;

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;


$settings=require_once __DIR__.'/settings.php';
$dependencies=require_once __DIR__.'/services_dependencies.php';
$actions=require_once __DIR__.'/actions_dependencies.php';

$builder=new ContainerBuilder();
$builder->addDefinitions($settings);
$builder->addDefinitions($dependencies);
$builder->addDefinitions($actions);


return $app;