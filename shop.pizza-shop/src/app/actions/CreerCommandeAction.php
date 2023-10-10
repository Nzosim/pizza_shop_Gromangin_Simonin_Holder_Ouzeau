<?php

namespace pizzashop\shop\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerCommandeAction {

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {


        $rs->getBody()->write(json_encode(['id' => 1]));
        return $rs;
    }
}

