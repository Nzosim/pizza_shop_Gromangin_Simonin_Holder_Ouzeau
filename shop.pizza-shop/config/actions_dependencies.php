<?php

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\CreerCommandeAction;

return [
    'commande.access' => function () {
        return new AccederCommandeAction();
    },
    'commande.create' => function () {
        return new CreerCommandeAction();
    }
];
