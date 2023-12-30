<?php

namespace pizzashop\auth\api\domain\auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\exceptions\CompteDejaExistant;
use pizzashop\auth\api\exceptions\EmailOuMotDePasseIncorrectException;
use pizzashop\auth\api\exceptions\TokenExpirerException;
use pizzashop\auth\api\exceptions\TokenIncorrectException;

/**
 * Class AuthProvider qui permet de gérer l'authentification
 */
class AuthProvider {

    /**
     * verifAuthEmailPassword permet de vérifier si l'email et le mot de passe sont corrects
     * @param $email
     * @param $password
     * @return array
     * @throws EmailOuMotDePasseIncorrectException
     */
    public function verifAuthEmailPassword($email, $password) {
        try {
            $user = Users::where('email', $email)->firstOrFail();
            if(!password_verify($password, $user->password)) throw new EmailOuMotDePasseIncorrectException();
        } catch (ModelNotFoundException $e) {
            throw new EmailOuMotDePasseIncorrectException();
        }
        // on génère un token qui est renvoyé à l'utilisateur si les credentials sont corrects
        $refreshToken = bin2hex(random_bytes(32));
        $user->refresh_token = $refreshToken;
        // ici on définit la date d'expiration du token à 1 heure
        $user->refresh_token_expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $user->save();
        return $this->profileInfo($user);
    }

    /**
     * verifAuthRefreshToken permet de vérifier si le token est correct
     * @param $refreshToken
     * @return array
     * @throws TokenExpirerException
     * @throws TokenIncorrectException
     */
    public function verifAuthRefreshToken($refreshToken) {
        try {
            $user = Users::where('refresh_token', $refreshToken)->firstOrFail();
            if($user->refresh_token_expiration_date < date('Y-m-d H:i:s')) throw new TokenExpirerException();
        } catch (ModelNotFoundException $e) {
            throw new TokenIncorrectException();
        }
        // on génère un token qui est renvoyé à l'utilisateur si le token donné est correct
        $refreshToken = bin2hex(random_bytes(32));
        $user->refresh_token = $refreshToken;
        // ici on définit la date d'expiration du token à 1 heure
        $user->refresh_token_expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $user->save();
        return $this->profileInfo($user);
    }

    /**
     * profileInfo permet de récupérer les informations de l'utilisateur
     * @param $user
     * @return array
     */
    public function profileInfo($user) : array {
        return [
            'email' => $user->email,
            'username' => $user->username,
            'refresh_token' => $user->refresh_token,
        ];
    }

    /**
     * newUser permet de créer un nouvel utilisateur
     * @param $email
     * @param $password
     * @param $username
     * @return bool
     */
    public function newUser($email, $password, $username) {
        // on verifie si le user contient deja un compte avec cet email
        $user = Users::where('email', $email)->first();
        if($user) return false;

        $user = new Users;
        $user->email = $email;
        $user->username = $username;
        $user->password = $password;
        $user->save();
        return true;
    }

    public function activateAccount() {
        // TODO PLUS TARD
    }

}