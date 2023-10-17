<?php


namespace pizzashop\auth\api\exceptions;

class JWTAuthIncorrectException extends \Exception
{

    public function __construct()
    {
        parent::__construct();
    }

}