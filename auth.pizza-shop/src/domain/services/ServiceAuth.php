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


    public function signin($email, $password)
    {
        $authProvider = new AuthProvider();
        $managerJWT = new ManagerJWT();
        $user = $authProvider->verifAuthEmailPassword($email, $password);
        $access_token = $managerJWT->creerJetons($user);
        $refresh_token = $user['refresh_token'];

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

    public function validate($token)
    {
        $managerJWT = new ManagerJWT();
        try {
            $access_token = $managerJWT->validerJeton($token);
        }catch(JWTAuthExpirerException $e) {
            throw new TokenExpirerException();
        }catch (JWTAuthIncorrectException $e) {
            throw new TokenIncorrectException();
        }
        return $access_token->upr;
    }

    public function refresh($refreshToken)
    {
        $authProvider = new AuthProvider();
        $managerJWT = new ManagerJWT();
        $user = $authProvider->verifAuthRefreshToken($refreshToken);
        $access_token = $managerJWT->creerJetons($user);
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