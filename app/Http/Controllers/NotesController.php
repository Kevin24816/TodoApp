<?php

namespace App\Http\Controllers;

use \App\Note;

class NotesController extends Controller
{

    // POST on /notes
    public function store() {
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue.", 400);
        }

        // create db row in notes
        Note::create([
            'title' => request("title"),
            'description' => request("description"),
            'user_id' => $user_id
        ]);

        // return user id
        return response()->json(['id' => $user_id], 201);
    }

    // GET on /notes
    public function retrieveNotes() {
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue".$user_id, 400);
        }

        // return array of note objects
        return response()->json(['notes' => Note::where('user_id', $user_id)->get()], 200);
    }

    // GET on /notes/{id}
    public function getSingleNote($id) {
        // check user id to make sure token matches
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue".$user_id, 400);
        }

        // check if note exists
        $note = Note::where([['id', $id], ["user_id", $user_id]])->first();
        if ($note == null) {
            return response("Note not found.", 400);
        }

        // return the note object
        return response()->json($note, 200);
    }

    // PUT on notes/{id}
    public function edit($id) {
        // check user id to make sure token matches
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue".$user_id, 400);
        }

        // check if note exists
        $note = Note::where([['id', $id], ["user_id", $user_id]])->first();
        if ($note == null) {
            return response("Note not found.", 400);
        }

        // update note
        $keyVals = request()->all();
        Note::where([['id', $id], ["user_id", $user_id]])->update($keyVals);

        // return the newly editednote object
        $note = Note::where([['id', $id], ["user_id", $user_id]])->get();
        return response()->json($note, 200);
    }

    // DELETE on notes/{id}
    public function destroy($id) {
        // check user id to make sure token matches
        $user_id = UserController::getUserID();
        if ($user_id == null) {
            return response("Session has expired. Login to continue".$user_id, 400);
        }

        // find and delete the note
        Note::where([['id', $id], ["user_id", $user_id]])->delete();
        return response("note deleted", 200);
    }

}
