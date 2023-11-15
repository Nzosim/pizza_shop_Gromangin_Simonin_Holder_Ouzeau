<?php

namespace pizzashop\shop\domain\service\exception;

/**
 * exception levée si un item de la commande est invalide
 */
class ServiceCommandeInvalidItemException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("La commande $UUID est déjà validée");
    }

}

