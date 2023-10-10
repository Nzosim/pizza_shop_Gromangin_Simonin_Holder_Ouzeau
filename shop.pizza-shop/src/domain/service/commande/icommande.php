<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface icommande {

    function accederCommande(string $UUID) : CommandeDTO;
    function validationCommande(string $UUID) : CommandeDTO;
    function creerCommande(CommandeDTO $commandeDTO) : CommandeDTO;

}