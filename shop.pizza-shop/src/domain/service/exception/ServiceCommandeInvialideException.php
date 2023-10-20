<?php

namespace pizzashop\shop\domain\service\exception;

class ServiceCommandeInvialideException extends \Exception {

    public function __construct(string $e) {
        parent::__construct($e);
    }

}
