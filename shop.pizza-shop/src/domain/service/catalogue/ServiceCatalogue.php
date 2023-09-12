<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use pizzashop\shop\domain\service\exception\ServiceProduitNotFoundException;

class ServiceCatalogue implements browse {

    function accederCommande(string $UUID): Commande {
        $commande = Commande::where('id', $UUID)->first();
        if ($commande == null) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        return $commande;
    }

    function accederProduit(string $numero_produit) : Produit {
        $produit = Produit::where('numero_produit', $numero_produit)->first();
        if ($produit == null) {
            throw new ServiceProduitNotFoundException($numero_produit);
        }
        return $produit;
    }
}