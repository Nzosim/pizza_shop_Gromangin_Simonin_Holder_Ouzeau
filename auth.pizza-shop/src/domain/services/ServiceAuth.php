<?php

namespace pizzashop\auth\api\domain\services;

use pizzashop\auth\api\domain\auth\AuthProvider;
use pizzashop\auth\api\domain\auth\ManagerJWT;
use pizzashop\auth\api\exceptions\JWTAuthExpirerException;
use pizzashop\auth\api\exceptions\JWTAuthIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;

/**
 * Class ServiceAuth qui permet de gérer l'authentification
 */
class ServiceAuth implements iauth{

    private AuthProvider $authProvider;
    private ManagerJWT $managerJWT;

    /**
     * constructeur qui permet d'instancier les classes AuthProvider et ManagerJWT
     * @param AuthProvider $authProvider
     * @param ManagerJWT $managerJWT
     */
    public function __construct(AuthProvider $authProvider, ManagerJWT $managerJWT)
    {
        $this->authProvider = $authProvider;
        $this->managerJWT = $managerJWT;
    }

    /**
     * signin permet de se connecter
     * @param $email
     * @param $password
     * @return array
     * @throws \pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException
     */
    public function signin($email, $password)
    {
        $user = $this->authProvider->verifAuthEmailPassword($email, $password);
        $access_token = $this->managerJWT->creerJetons($user);
        $refresh_token = $user['refresh_token'];
        // on renvoie le token et le refresh token
        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

    /**
     * validate permet de valider un token
     * @param $token
     * @return mixed
     * @throws TokenExpirerException
     * @throws TokenIncorrectException
     */
    public function validate($token)
    {
        try {
            $access_token = $this->managerJWT->validerJeton($token);
        }catch(JWTAuthExpirerException $e) {
            throw new TokenExpirerException();
        }catch (JWTAuthIncorrectException $e) {
            throw new TokenIncorrectException();
        }
        return $access_token->upr;
    }

    /**
     * refresh permet de rafraîchir un token
     * @param $refreshToken
     * @return array
     * @throws TokenExpirerException
     * @throws TokenIncorrectException
     */
    public function refresh($refreshToken)
    {
        $user = $this->authProvider->verifAuthRefreshToken($refreshToken);
        $access_token = $this->managerJWT->creerJetons($user);
        $refresh_token = $user['refresh_token'];
        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

    public function signup($email, $password, $username)
    {
        // PLUS TARD
    }

    public function activate($token)
    {
        // PLUS TARD
    }
}