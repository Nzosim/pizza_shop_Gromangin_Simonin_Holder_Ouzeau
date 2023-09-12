<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\catalogue\CommandeDTO;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use pizzashop\shop\domain\service\ServiceCatalogue;

class ServiceCommande implements commande {

    private ServiceCatalogue $serviceCatalogue;

    function __construct(ServiceCatalogue $serviceCatalogue) {
        $this->serviceCatalogue = $serviceCatalogue;
    }

    function accederCommande(string $UUID): CommandeDT0 {
        $commandeDTO = $this->serviceCatalogue->accederCommande($UUID);
        if ($commandeDTO == null) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        return $commandeDTO;
    }

    function validerCommande(string $UUID): CommandeDTO
    {
        // TODO: Implement validerCommande() method.
    }

    function creerCommande(CommandeDTO $commandeDTO): CommandeDT0 {

    }
}