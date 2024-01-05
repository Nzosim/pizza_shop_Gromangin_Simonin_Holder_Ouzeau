<?php

namespace pizzashop\catalogue\domain\service\exception;

/**
 * exception
 */
class IdManquantException extends \Exception {

    public function __construct() {
        parent::__construct("Il manque l'id du produit en paramètre");
    }

}
