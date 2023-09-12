<?php

namespace pizzashop\shop\domain\service\commande;

interface commande {

    function accederCommande(string $UUID) : CommandeDTO;
    function validerCommande(string $UUID) : CommandeDTO;

}