<?php

namespace pizzashop\shop\domain\service\exception;

/**
 * Description of ServiceCommandeInvalideException
 */
class ServiceCommandeNotFoundException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("Commande $UUID non trouvée", 404);
    }

}