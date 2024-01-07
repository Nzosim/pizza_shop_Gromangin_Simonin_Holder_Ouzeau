<?php
return [
    'logger.commande.name' => 'commande',
    'log.commande.file' => __DIR__ . '/../logs/logFile.log',
    'log.commande.level' => \Monolog\Level::Debug,
    'guzzle.base_uri' => getenv('GUZZLE_URL'),
];

