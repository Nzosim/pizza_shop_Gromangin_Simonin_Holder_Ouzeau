<?php

namespace pizzashop\catalogue\domain\service\catalogue;

use pizzashop\catalogue\domain\dto\catalogue\ProduitDTO;

interface icatalogue {

    function getProduit($numero, $taille) : ProduitDTO;

    function getProduitById($numero) : array;

    function getAllProduits() : array;

    function getProduitByCategorie($categorie) : array;

}