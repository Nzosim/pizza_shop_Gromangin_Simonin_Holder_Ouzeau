<?php

namespace pizzashop\catalogue\domain\service\exception;

/**
 * exception levée si un produit n'est pas trouvé
 */
class ServiceProduitNotFoundException extends \Exception
{

    public function __construct(string $numero_produit)
    {
        parent::__construct("Produit $numero_produit non trouvé");
    }

}