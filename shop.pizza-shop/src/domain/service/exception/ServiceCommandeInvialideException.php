<?php

namespace pizzashop\shop\domain\service\exception;

/**
 * exception levée si la commande n'est pas valide
 */
class ServiceCommandeInvialideException extends \Exception {

    public function __construct(string $e) {
        parent::__construct($e);
    }

}
