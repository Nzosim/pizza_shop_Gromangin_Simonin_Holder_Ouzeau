<?php

namespace pizzashop\shop\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\service\exception\ServiceProduitNotFoundException;

class ServiceCatalogue implements icatalogue {

    function __construct() {}

    function getProduit($numero, $taille) : ProduitDTO {
        try {
            $produit = Produit::where('numero', '=', $numero)->firstOrFail();
        }catch (ModelNotFoundException $e) {
            throw new ServiceProduitNotFoundException($numero);
        }
        return $produit->toDTO($taille);
    }

}