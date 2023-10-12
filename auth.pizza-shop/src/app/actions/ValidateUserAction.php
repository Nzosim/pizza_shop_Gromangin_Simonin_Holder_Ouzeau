<?php

namespace pizzashop\auth\api\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ValidateUserAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {


        $responseData = ['message' => 'Authentification réussie'];
        $rs->getBody()->write(json_encode($responseData));
        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
//        return JSONRenderer::render($rs, 200, "");

    }
}

