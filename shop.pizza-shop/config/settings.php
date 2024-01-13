<?php
return [
    'logger.commande.name' => 'commande',
    'log.commande.file' => __DIR__ . '/../logs/logFile.log',
    'log.commande.level' => \Monolog\Level::Debug,
    'auth_base_uri' => getenv('AUTH_API'),
    'commande_base_uri' => getenv('SHOP_API'),
    'catalogue_base_uri' => getenv('CATALOG_API'),
];

