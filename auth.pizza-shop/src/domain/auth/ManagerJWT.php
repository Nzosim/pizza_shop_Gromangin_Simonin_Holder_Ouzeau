<?php

namespace pizzashop\auth\api\domain\auth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use pizzashop\auth\api\exceptions\JWTAuthExpirerException;
use pizzashop\auth\api\exceptions\JWTAuthIncorrectException;

/**
 * Class ManagerJWT qui permet de gérer les jetons
 */
class ManagerJWT {

    // clé secrète pour générer le token
    private string $secretKey;
    // temps d'expiration du token
    private string $expirationTime;

    public function __construct(string $secretKey, int $expirationTime) {
        // on récupère la clé secrète et le temps d'expiration du token
        // la clé secrête est une variable d'environnement
        $this->secretKey = $secretKey;
        $this->expirationTime = $expirationTime;
    }

    /**
     * creerJetons permet de créer un jeton payload
     * @param $donnees
     * @return string
     */
    public function creerJetons($donnees) {
        // on définit le payload
        $payload = [
            'iss' => "auth.pizza-shop",
            'iat' => time(),
            // ajouter le temps d'expiration en seconde à la date de création
            'exp' => time() + $this->expirationTime,
            'upr' => $donnees
        ];
        // on encode le payload avec la clé secrète
        $jwt = JWT::encode($payload, $this->secretKey, 'HS512');

        return $jwt;
    }

    /**
     * validerJeton permet de valider un jeton
     * @param $jeton
     * @return \stdClass
     * @throws JWTAuthExpirerException
     * @throws JWTAuthIncorrectException
     */
    public function validerJeton($jeton) {
        try {
            // on décode le jeton
            $decoded = JWT::decode($jeton, new Key($this->secretKey, 'HS512'));
        }catch (ExpiredException $e) {
            // si le jeton est expiré, on lance une exception
            throw new JWTAuthExpirerException();
        }catch (SignatureInvalidException | \UnexpectedValueException | \DomainException $e) {
            // si le jeton est incorrect, on lance une exception
            throw new JWTAuthIncorrectException();
        }
        return $decoded;
    }
}