<?php


namespace pizzashop\shop\domain\service\exception;

class TokenInexistantException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Vous devez être connecté", 401);
    }

}