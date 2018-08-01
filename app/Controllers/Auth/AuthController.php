<?php

namespace App\Controllers\Auth;

use App\Models\User;

use App\Controllers\Controller;

class AuthController extends Controller
{
    public function getSignUp($req, $res)
    {
        return $this->view->render($res, 'auth/signup.twig');
    }

    public function postSignUp($req, $res)
    {
        User::create([
            'email' => $req->getParam('email'),
            'name' => $req->getParam('name'),
            'password' => password_hash(hash('sha512', $req->getParam('password')), PASSWORD_BCRYPT)
        ]);
    }
}