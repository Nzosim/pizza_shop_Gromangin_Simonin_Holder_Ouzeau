<?php
declare(strict_types=1);

use pizzashop\shop\domain\service\Eloquent;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$appli = require_once __DIR__ . '/../config/bootstrap.php';

(require_once __DIR__ . '/../config/routes.php')($appli);

//Eloquent::init(__DIR__ . '/../config/commande.db.ini');

$appli->run();
