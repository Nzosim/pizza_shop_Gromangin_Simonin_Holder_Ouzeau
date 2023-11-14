<?php

namespace pizzashop\auth\api\domain\services;

/**
 * Interface iauth qui permet de gérer l'authentification
 */
interface iauth {

    public function signin($email, $password);

    public function validate($token);

    public function refresh($refreshToken);

    public function signup($email, $password, $username);

    public function activate($token);

}