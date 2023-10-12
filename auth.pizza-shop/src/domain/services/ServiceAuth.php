<?php

namespace pizzashop\auth\api\domain\services;

use pizzashop\auth\api\domain\auth\AuthProvider;
use pizzashop\auth\api\domain\auth\ManagerJWT;
use pizzashop\auth\api\domain\entities\Users;

class ServiceAuth implements iauth{


    public function signin($email, $password)
    {
        $authProvider = new AuthProvider();
        $managerJWT = new ManagerJWT();
        $user = $authProvider->verifAuthEmailPassword($email, $password);
        $profile = $authProvider->profileInfo($user);
        $access_token = $managerJWT->creerJetons($profile);
        $refresh_token = $user->refresh_token;
        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

    public function validate($token)
    {
        $managerJWT = new ManagerJWT();
        return $managerJWT->validerJeton($token);
    }

    public function refresh($refreshToken)
    {
        $authProvider = new AuthProvider();
        $managerJWT = new ManagerJWT();
        $user = $authProvider->verifAuthRefreshToken($refreshToken);
        $profile = $authProvider->profileInfo($user);
        $access_token = $managerJWT->creerJetons($profile);
        $refresh_token = $user->refresh_token;

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