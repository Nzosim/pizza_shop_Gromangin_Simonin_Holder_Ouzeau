<?php

namespace pizzashop\shop\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\service\exception\ServiceProduitNotFoundException;

/**
 * Service de gestion du catalogue
 */
class ServiceCatalogue implements icatalogue {

    function __construct() {}

    /**
     * Retourne un produit du catalogue en fonction de son numéro et de la taille
     * @param $numero
     * @param $taille
     * @return ProduitDTO
     * @throws ServiceProduitNotFoundException
     */
    function getProduit($numero, $taille) : ProduitDTO {
        try {
            $produit = Produit::where('numero', '=', $numero)->firstOrFail();
        }catch (ModelNotFoundException $e) {
            throw new ServiceProduitNotFoundException($numero);
        }
        return $produit->toDTO($taille);
    }

}