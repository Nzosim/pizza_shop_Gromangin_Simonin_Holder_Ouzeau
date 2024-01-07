<?php
return [
    'auth.secret' => getenv('SECRET_KEY'),
    'auth.time' => 15000,
    'guzzle.base_uri' => getenv('GUZZLE_URL'),
];

