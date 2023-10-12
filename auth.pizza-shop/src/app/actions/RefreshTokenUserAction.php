<?php


namespace pizzashop\auth\api\app\actions;

use pizzashop\shop\app\renderer\JSONRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RefreshTokenUserAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        return JSONRenderer::render($rs, 200, "");

    }
}

