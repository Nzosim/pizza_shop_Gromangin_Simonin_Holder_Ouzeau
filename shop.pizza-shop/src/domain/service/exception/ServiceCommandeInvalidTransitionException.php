<?php

namespace pizzashop\shop\domain\service\exception;

class ServiceCommandeInvalidTransitionException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("La commande $UUID est déjà validée");
    }

}
