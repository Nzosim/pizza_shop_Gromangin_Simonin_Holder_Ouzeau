<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\commande\Item;

class ServiceCatalogue implements icatalogue {

    function __construct() {}

    function getProduit($numero, $taille, $quantite): Item {
        $item = Item::where('numero', 'like', $numero);
        return $item->toDTO();
    }

}