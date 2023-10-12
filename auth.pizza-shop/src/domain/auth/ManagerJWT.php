<?php

namespace pizzashop\auth\api\domain\auth;

class ManagerJWT {

    private string $secretKey;
    private string $expirationTime;

    public function __construct() {
        $this->secretKey = "key";
        $this->expirationTime = 15000;
    }

    public function creerJetons($donnees) {
        $payload = [
            'iss' => "auth.pizza-shop",
            'iat' => time(),
            'exp' => time() + $this->expirationTime,
            'upr' => $donnees
        ];
        $jwt = \Firebase\JWT\JWT::encode($payload, $this->secretKey, 'HS512');
        return $jwt;
    }

    public function validerJeton($jeton) {
        try {
            $decoded = \Firebase\JWT\JWT::decode($jeton, new Key($this->secretKey,'HS512'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

}