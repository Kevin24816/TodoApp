<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    # creates a new user
    public function createUser() {}

    # authenticates a user who is trying to log in
    public function authenticate($username, $password) {
//        return !DB::table('users')->where([['username', $username], ['password', $password]])->isEmpty();
        // TODO: what is redirect
        // TODO: how to pass parameters
        // https://laravel.com/docs/5.5/authentication
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->intended('dashboard');
        }
    }

    # logs a user out by destroying the token
    public function logout() {}

}
