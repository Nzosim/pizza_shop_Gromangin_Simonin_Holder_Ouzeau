<?php

namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas d'email ou de mot de passe incorrect
 */
class EmailOuMotDePasseIncorrectException extends \Exception {

    public function __construct() {
        parent::__construct("Email ou mot de passe incorrect", 401);
    }

}