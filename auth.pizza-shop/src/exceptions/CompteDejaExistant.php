<?php

namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas d'email ou de mot de passe incorrect
 */
class CompteDejaExistant extends \Exception {

    public function __construct() {
        parent::__construct("Compte déjà existant avec cet email");
    }

}