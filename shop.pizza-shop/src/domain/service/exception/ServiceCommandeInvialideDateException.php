<?php

namespace pizzashop\shop\domain\service\exception;

class ServiceCommandeInvialideDateException extends \Exception {

    public function __construct(string $e) {
        parent::__construct($e);
    }

}
