<?php

namespace App\Http\Controllers;

use \App\User;
use \App\Note;

class UserController extends Controller
{
    public static $token_length = 32;

    // POST to /users
    public function signup() {
        $username = request("username");
        $password = request("password");
        $password_conf = request("password_confirmation");

        // check if passwords mismatched or username is taken
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

        // return the api token
        return response()->json(["token" => $token, "username" => $username], 201);
    }

    // POST to /auth
    public function login() {
        $username = request("username");
        $password = request("password");

        // check if username and passwords match that in the database
        $correct_password = User::where('username', $username)->value('password');
        $password_matches = $password === $correct_password;
        if (!$password_matches) {
            return response("login failed", 400);
        }

        // generate new token and store token in database
        $token = bin2hex(random_bytes(self::$token_length));
        User::where('username', $username)->update(array('api_token' => $token));

        // return the api token
        return response()->json(["token" => $token, "username" => $username], 201);
    }

    // DELETE to /auth
    public function logout() {
        $user_id = self::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue.");
        }

        // destroy the token
        User::where('id', $user_id)->update(array('api_token' => "INVALID"));

        return response("User logged out", 200);
    }

    // DELETE on /users
    public function destroy() {
        // check user id to make sure token matches
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue", 400);
        }

        // find and delete both the user's notes and the user
        Note::where("user_id", $user_id)->delete();
        User::where("id", $user_id)->delete();
        return response("user deleted", 200);
    }

    // get the user id from the token in the request header
    public static function getUserID() {
        $token_header = request()->header("Authorization");
        $token = explode(' ', $token_header)[1];
        return User::where('api_token', $token)->value('id');
    }
}
