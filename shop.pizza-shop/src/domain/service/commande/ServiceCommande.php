<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\catalogue\CommandeDTO;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;

class ServiceCommande implements commande {

    private ServiceCatalogue $serviceCatalogue;

    function __construct(ServiceCatalogue $serviceCatalogue) {
        $this->serviceCatalogue = $serviceCatalogue;
    }

    function accederCommande(string $UUID): CommandeDTO
    {
        $commande = $this->serviceCatalogue->accederCommande($UUID);
        $commandeDTO = new CommandeDTO($commande->UUID(), $commande->date(), $commande->type_livraison(), $commande->mail_client(), $commande->montant(), $commande->delai(), $commande->produits());
        return $commandeDTO;
    }

    function validerCommande(string $UUID) : void {
        // TODO: Implement validerCommande() method.
    }

    function creerCommande(CommandeDTO $commandeDTO): CommandeDT0
    {

    }
}