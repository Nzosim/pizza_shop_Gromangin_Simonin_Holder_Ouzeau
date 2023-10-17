<?php

namespace pizzashop\auth\api\domain\auth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use pizzashop\auth\api\exceptions\JWTAuthExpirerException;
use pizzashop\auth\api\exceptions\JWTAuthIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;

class ManagerJWT {

    private string $secretKey;
    private string $expirationTime;

    public function __construct() {
        $this->secretKey = getenv('SECRET_KEY');
        $this->expirationTime = 15000;
    }

    public function creerJetons($donnees) {
        $payload = [
            'iss' => "auth.pizza-shop",
            'iat' => time(),
            // ajouter le temps d'expiration en seconde à la date de création
            'exp' => time() + $this->expirationTime,
            'upr' => $donnees
        ];
        $jwt = JWT::encode($payload, $this->secretKey, 'HS512');

        return $jwt;
    }

    public function validerJeton($jeton) {
        try {
            $decoded = JWT::decode($jeton, new Key($this->secretKey, 'HS512'));
        }catch (ExpiredException $e) {
            throw new JWTAuthExpirerException();
        }catch (SignatureInvalidException | \UnexpectedValueException | \DomainException $e) {
            throw new JWTAuthIncorrectException();
        }
        return $decoded;
    }

}