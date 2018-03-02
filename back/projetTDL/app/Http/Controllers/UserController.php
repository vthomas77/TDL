<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::all();
        return response()->json($users);
    }

    public function getUser($id) {
        $users = User::find($id);
        return response()->json($users);
    }

    public function saveUser($username, $email , $password) {
        $newUser = User::createUser($username, $email, $password);
        return response()->json($newUser);
    }

    public function deleteUser($id) {
        $users = User::find($id);
        $users->delete();

        return response()->json('success');
    }

    public function updateUser(Request $request, $id) {
        $users = User::find($id);

        $users->username = $request->input('username');
        $users->email = $request->input('email');
        $users->avatar = $request->input('avatar');
        $users->password = $request->input('password');

        $users->save();

        return response()->json($users);
    }

    // Get user id
    public function GetUserID($userToken){
      return response()->json(User::GetUserID($userToken));
    }

}
