<?php

namespace pizzashop\catalogue\domain\service\exception;

/**
 * exception
 */
class CategorieNotFoundException extends \Exception {

    public function __construct($id) {
        parent::__construct("La catégorie $id n'existe pas");
    }

}
