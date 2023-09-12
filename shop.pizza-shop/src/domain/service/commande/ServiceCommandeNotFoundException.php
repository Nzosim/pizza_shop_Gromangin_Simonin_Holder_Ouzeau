<?php

namespace pizzashop\shop\domain\service\commande;

class ServiceCommandeNotFoundException extends \Exception {

    public function __construct(string $UUID) {
        parent::__construct("Commande $UUID non trouvée");
    }

}