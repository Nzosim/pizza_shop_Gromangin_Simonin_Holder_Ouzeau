<?php

namespace pizzashop\shop\domain\service\exception;

/**
 * exception
 */
class IdCategorieManquantException extends \Exception {

    public function __construct() {
        parent::__construct("Il manque l'id de la categorie en paramètre");
    }

}
