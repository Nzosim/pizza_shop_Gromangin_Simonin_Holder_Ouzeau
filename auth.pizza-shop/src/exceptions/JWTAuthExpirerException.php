<?php


namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas de JWT jeton expiré
 */
class JWTAuthExpirerException extends \Exception
{

    public function __construct()
    {
        parent::__construct();
    }

}