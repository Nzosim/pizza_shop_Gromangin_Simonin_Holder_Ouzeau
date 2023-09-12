<?php

namespace pizzashop\shop\domain\service;

class ServiceCommande implements commande {

    private ServiceCatalogue $serviceCatalogue;

    function __construct(ServiceCatalogue $serviceCatalogue) {
        $this->serviceCatalogue = $serviceCatalogue;
    }

}