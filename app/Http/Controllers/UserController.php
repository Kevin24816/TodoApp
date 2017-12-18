<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    // POST to /users
    public function signup() {
        $username = request("username");
        $password = request("password");
        $password_conf = request("password_confirmation");

        // TODO: implement token, which will be created and stored in database

    }

    // POST to /auth
    public function login() {
        $username = request("username");
        $password = request("password");


    }

    // DELETE to /auth
    public function logout() {

    }

}
