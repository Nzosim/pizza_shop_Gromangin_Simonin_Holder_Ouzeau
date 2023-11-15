<?php

namespace pizzashop\shop\domain\service;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * permet d'initialiser Eloquent
 */
class Eloquent
{

    public static function init($filename): void
    {

        $db = new DB();
        $db->addConnection(parse_ini_file($filename));
        $db->setAsGlobal();
        $db->bootEloquent();

    }

}