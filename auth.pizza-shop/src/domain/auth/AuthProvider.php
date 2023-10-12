<?php

namespace pizzashop\auth\api\domain\auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;

class AuthProvider {

    public function verifAuthEmailPassword($email, $password) {
        try {
            $user = Users::where('email', $email)->firstOrFail();
            if(!password_verify($password, $user->password)) throw new EmailOuMotDePasseIncorrectException();
        } catch (ModelNotFoundException $e) {
            throw new EmailOuMotDePasseIncorrectException();
        }
        return $user;
    }

    public function verifAuthRefreshToken($refreshToken) {
        return Users::where('refresh_token', $refreshToken)->first();
    }

    public function profileInfo($profile) {
        // a voir apres pour trouver les infos a retourner
        // en fonction du format de $profile
        return $profile;
    }

    public function newUser() {
        // TODO
    }

    public function activateAccount() {
        // TODO
    }

}