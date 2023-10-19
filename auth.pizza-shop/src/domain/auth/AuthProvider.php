<?php

namespace pizzashop\auth\api\domain\auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;

class AuthProvider {

    public function verifAuthEmailPassword($email, $password) {
        try {
            $user = Users::where('email', $email)->firstOrFail();
            if(!password_verify($password, $user->password)) throw new EmailOuMotDePasseIncorrectException();
        } catch (ModelNotFoundException $e) {
            throw new EmailOuMotDePasseIncorrectException();
        }
        $refreshToken = bin2hex(random_bytes(32));
        $user->refresh_token = $refreshToken;
        $user->refresh_token_expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $user->save();
        return $this->profileInfo($user);
    }

    public function verifAuthRefreshToken($refreshToken) {
        try {
            $user = Users::where('refresh_token', $refreshToken)->firstOrFail();
            if($user->refresh_token_expiration_date < date('Y-m-d H:i:s')) throw new TokenExpirerException();
        } catch (ModelNotFoundException $e) {
            throw new TokenIncorrectException();
        }
        $refreshToken = bin2hex(random_bytes(32));
        $user->refresh_token = $refreshToken;
        $user->refresh_token_expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $user->save();
        return $this->profileInfo($user);
    }

    public function profileInfo($user) : array {
        return [
            'email' => $user->email,
            'username' => $user->username,
            'refresh_token' => $user->refresh_token,
        ];
    }

    public function newUser() {
        // TODO PLUS TARD
    }

    public function activateAccount() {
        // TODO PLUS TARD
    }

}