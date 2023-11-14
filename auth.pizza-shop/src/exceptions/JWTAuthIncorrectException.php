<?php


namespace pizzashop\auth\api\exceptions;

/**
 * Exception en cas de JWT jeton incorrect
 */
class JWTAuthIncorrectException extends \Exception
{

    public function __construct()
    {
        parent::__construct();
    }

}