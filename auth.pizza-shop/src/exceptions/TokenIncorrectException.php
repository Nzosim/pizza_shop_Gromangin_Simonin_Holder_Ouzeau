<?php


namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas d'email ou de mot de passe incorrect
 */
class TokenIncorrectException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Token incorrect", 401);
    }

}