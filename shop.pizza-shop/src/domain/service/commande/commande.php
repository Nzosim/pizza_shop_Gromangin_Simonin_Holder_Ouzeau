<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\catalogue\CommandeDTO;

interface commande {

    function accederCommande(string $UUID) : CommandeDTO;
    function validerCommande(string $UUID) : CommandeDTO;
    function creerCommande(CommandeDTO $commandeDTO) : CommandeDTO;

}