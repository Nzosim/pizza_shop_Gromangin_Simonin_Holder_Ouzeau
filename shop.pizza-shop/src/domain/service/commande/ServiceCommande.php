<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\catalogue\CommandeDTO;
use pizzashop\shop\domain\service\ServiceCatalogue;

class ServiceCommande implements commande {

    private ServiceCatalogue $serviceCatalogue;

    function __construct(ServiceCatalogue $serviceCatalogue) {
        $this->serviceCatalogue = $serviceCatalogue;
    }

    function accederCommande(string $UUID): CommandeDTO
    {
        // TODO: Implement accederCommande() method.
    }

    function validerCommande(string $UUID): CommandeDTO
    {
        // TODO: Implement validerCommande() method.
    }
}