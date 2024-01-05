<?php

use pizzashop\catalogue\domain\service\catalogue\ServiceCatalogue;

return [
    'product.service' => function () {
        return new ServiceCatalogue();
    }
];
