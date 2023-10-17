<?php

namespace pizzashop\auth\api\domain\services;

use pizzashop\auth\api\domain\auth\AuthProvider;
use pizzashop\auth\api\domain\auth\ManagerJWT;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\exceptions\JWTAuthExpirerException;
use pizzashop\auth\api\exceptions\JWTAuthIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;

class ServiceAuth implements iauth{

    private AuthProvider $authProvider;
    private ManagerJWT $managerJWT;

    public function __construct(AuthProvider $authProvider, ManagerJWT $managerJWT)
    {
        $this->authProvider = $authProvider;
        $this->managerJWT = $managerJWT;
    }

    public function signin($email, $password)
    {
        $user = $this->authProvider->verifAuthEmailPassword($email, $password);
        $access_token = $this->managerJWT->creerJetons($user);
        $refresh_token = $user['refresh_token'];

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

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