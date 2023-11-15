<?php

namespace pizzashop\shop\domain\service\catalogue;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface icatalogue {

    function getProduit($numero, $taille) : ProduitDTO;

}