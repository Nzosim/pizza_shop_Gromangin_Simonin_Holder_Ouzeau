<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\commande\Item;

interface icatalogue {

    function getProduit($numero, $taille, $quantite): Item;

}