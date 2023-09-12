<?php

namespace pizzashop\shop\domain\service\catalogue;

interface browse {

    function accederCommande(string $UUID) : Commande;
}