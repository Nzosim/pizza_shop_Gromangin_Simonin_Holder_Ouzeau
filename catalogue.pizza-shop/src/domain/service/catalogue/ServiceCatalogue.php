<?php

namespace pizzashop\catalogue\domain\service\catalogue;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\catalogue\domain\service\catalogue\icatalogue;
use pizzashop\catalogue\domain\dto\catalogue\ProduitDTO;
use pizzashop\catalogue\domain\entities\catalogue\Produit;
use pizzashop\catalogue\domain\service\exception\CategorieNotFoundException;
use pizzashop\catalogue\domain\service\exception\ServiceProduitNotFoundException;

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

    /**
     * Retourne un produit du catalogue en fonction de son numéro
     * @param $numero
     * @return array
     * @throws ServiceProduitNotFoundException
     */
    function getProduitById($numero) : array {
        //get un produit et le retourne en tant que tableau, affiche son prix en fonction de chaque taille
        try {
            $produit = Produit::where('numero', '=', $numero)->firstOrFail();
        }catch (ModelNotFoundException $e) {
            throw new ServiceProduitNotFoundException($numero);
        }
        $produitDTO = array();
        foreach ($produit->tailles()->get() as $taille) {
            $res = $produit->toDTO($taille->id);
            $res->setTaille($taille->id);
            $produitDTO[] = $res;
        }
        return $produitDTO;
    }

    /**
     * Retourne tous les produits du catalogue
     * @return array
     */
    function getAllProduits() : array
    {
        $produits = Produit::all();
        $produitsDTO = array();
        foreach ($produits as $produit) {
            $produitsDTO[] = $produit->toDTO($produit->tailles()->get()->first()->id);
        }
        return $produitsDTO;
    }

    /**
     * Retourne tous les produits du catalogue en fonction de la catégorie
     * @param $categorie_id int id de la catégorie
     * @return array tableau de ProduitDTO
     */
    function getProduitByCategorie($categorie_id) : array
    {
        try {
            $produits = Produit::where('categorie_id', '=', $categorie_id)->get();
            if($produits->isEmpty()) throw new ModelNotFoundException();
            $produitsDTO = array();
            foreach ($produits as $produit) {
                $produitsDTO[] = $produit->toDTO($produit->tailles()->get()->first()->id);
            }
        }catch (ModelNotFoundException $e) {
            throw new CategorieNotFoundException($categorie_id);
        }
        return $produitsDTO;
    }

}