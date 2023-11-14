<?php


namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas de token expiré
 */
class TokenExpirerException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Token expiré", 401);
    }

}