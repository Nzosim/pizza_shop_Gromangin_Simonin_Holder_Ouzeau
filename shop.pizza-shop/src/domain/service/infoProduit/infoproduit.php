<?php

namespace pizzashop\shop\domain\service\infoProduit;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Item;

interface infoproduit
{

    function getProduit($numero, $taille, $quantite): Item;

}