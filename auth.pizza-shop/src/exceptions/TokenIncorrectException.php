<?php


namespace pizzashop\auth\api\exceptions;

class TokenIncorrectException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Token incorrect", 401);
    }

}