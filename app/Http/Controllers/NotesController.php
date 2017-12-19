<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use \App\Note;

class NotesController extends Controller
{

    // POST on /notes
    public function store() {
        $user_id = Session::get('user_id');
        if ($user_id == null) {
            return response("Session has expired. Login to continue.", 400);
        }

        Note::create([
            'title' => request("title"),
            'description' => request("description"),
            'user_id' => $user_id
        ]);

        return response()->json(['id' => $user_id], 201);
    }

    // GET on /notes
    public function retrieveNotes() {
        $user_id = Session::get('user_id');
        if ($user_id == null) {
            return response("Session has expired. Login to continue.", 400);
        }

        return response()->json(['notes' => Note::where('user_id', $user_id)->get()], 200);
    }

    // GET on /notes/{id}
    public function getSingleNote($id) {
        $note = Note::where('id', $id)->first();
        if ($note == null) {
            return response("Note not found.", 400);
        }

        return response()->json($note, 200);
    }

    // PUT on notes/{id}
    public function edit($id) {
        // check if note exists
        $note = Note::where('id', $id)->first();
        if ($note == null) {
            return response("Note not found.", 400);
        }

        // update note
        $keyVals = request()->all();
        Note::where('id', $id)->update($keyVals);

        return response()->json(Note::where('id', $id)->get(), 200);
    }

    // DELETE on notes/{id}
    public function destroy($id) {
        Note::where('id', $id)->delete();
        return response("note deleted", 200);
    }

}
