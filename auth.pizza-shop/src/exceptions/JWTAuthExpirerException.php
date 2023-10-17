<?php


namespace pizzashop\auth\api\exceptions;

class JWTAuthExpirerException extends \Exception
{

    public function __construct()
    {
        parent::__construct();
    }

}