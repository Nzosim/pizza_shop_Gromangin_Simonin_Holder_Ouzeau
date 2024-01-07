<?php


namespace pizzashop\shop\domain\service\exception;

/**
 * exception levée si le token est inéxistant
 */
class TokenInexistantException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Vous devez entrer un token pour vous connecter", 401);
    }

}