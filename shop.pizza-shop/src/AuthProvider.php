<?php

namespace pizzashop\shop;

use pizzashop\auth\api\domain\entities\Users;

class AuthProvider {

    public function verifAuthEmailPassword($email, $password) {
        $user = Users::where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return true;
            }
        }
        return false;
    }

    public function verifAuthRefreshToken($refreshToken) {
        $user = Users::where('refresh_token', $refreshToken)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public function profileInfo($email) {
        $user = Users::where('email', $email)->first();
        return $user;
    }

    public function newUser() {
        // TODO
    }

    public function activateAccount() {
        // TODO
    }

}