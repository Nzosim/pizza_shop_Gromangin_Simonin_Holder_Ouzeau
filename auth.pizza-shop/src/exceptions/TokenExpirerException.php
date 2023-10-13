<?php


namespace pizzashop\auth\api\exceptions;

class TokenExpirerException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Token expiré", 401);
    }

}