<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface commande {

    function accederCommande(string $UUID) : CommandeDTO;
    function validerCommande(string $UUID) : void;

}