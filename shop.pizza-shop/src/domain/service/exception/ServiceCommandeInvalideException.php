<?php

namespace pizzashop\shop\domain\service\exception;

class ServiceCommandeInvalideException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("Commande $UUID non valide", 400);
    }

}