<?php

namespace pizzashop\shop\domain\service\exception;

/**
 * exception levée si la commande n'est pas valide
 */
class ServiceCommandeInvalideException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("Commande $UUID non valide", 400);
    }

}