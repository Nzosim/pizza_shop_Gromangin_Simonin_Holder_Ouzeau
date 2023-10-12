<?php

namespace pizzashop\auth\api\exceptions;

class EmailOuMotDePasseIncorrectException extends \Exception {

    public function __construct() {
        parent::__construct("Email ou mot de passe incorrect", 401);
    }

}