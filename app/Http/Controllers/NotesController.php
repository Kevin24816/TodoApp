<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotesController extends Controller
{

    // POST on /notes
    public function store() {

        $note = new Notes;

        $note->title = request("title");
        $note->description = request("description");

        $note->save;
        return redirect("/notes");
    }

    // GET on /notes
    public function getAllNotes() {
        return static::where('user_id', $user_id)->get();
    }

    // GET on /notes/{id}
    public function getSingleNote($id) {
        return static::where('id', $id)->get();
    }

    // PUT on notes/{id}
    public function edit($id) {

    }

    // DELETE on notes/{id}
    public function destroy($id) {

    }

}
