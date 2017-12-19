<?php

namespace App\Http\Controllers;

use \App\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public static $token_length = 32;

    // POST to /users
    public function signup() {

        $username = request("username");
        $password = request("password");
        $password_conf = request("password_confirmation");

        $password_matches = $password === $password_conf;
        $username_taken = User::where('username', $username)->first() !== null;

        if (!$password_matches || $username_taken) {
            return response("Sign up invalid", 400);
        }

        // generate api token
        $token = bin2hex(random_bytes(self::$token_length));

        // store user in the database
        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->api_token = $token;
        $user->save();

        return response()->json(["token" => $token], 201);
    }

    // POST to /auth
    public function login() {
        $username = request("username");
        $password = request("password");

        $correct_password = User::where('username', $username)->value('password');
        $password_matches = $password === $correct_password;

        if (!$password_matches) {
            return response("login failed", 400);
        }

        $user_id = $correct_password = User::where('username', $username)->value('id');
        Session::put('user_id', $user_id);

        // generate new token and store token in database
        $token = bin2hex(random_bytes(self::$token_length));
        User::where('username', $username)->update(array('api_token' => $token));

        return response($token, 201);
    }

    // DELETE to /auth
    public function logout() {
        $user_id = Session::get('user_id');
        if ($user_id == null) {
            return response("Session has expired. Login to continue.");
        }

        // destroy the token
        User::where('id', $user_id)->update(array('api_token' => "INVALID"));

        Session::forget('user_id');
        return response("User logged out", 200);
    }

}