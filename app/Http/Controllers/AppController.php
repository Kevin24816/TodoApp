<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class appController extends Controller
{
    public function index() {
        $name = "Kev";
        return view('welcome', compact('name'));
    }

    # creates a new user
    public function createUser() {}

    # authenticates a user who is trying to log in
    public function authenticate() {}

    # logs a user out by destroying the token
    public function logout() {}

    # creates a new note
    public function createNote() {}

    # retrieves all notes for the user.
    public function retrieveAllNotes() {}

    # retrieve a single note by its id in the database
    public function retrieveNote() {}

    # edit the fields of a note
    public function editNote() {}

    # delete a note from the DB
    public function deleteNote() {}
}
