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

    public function readUser($token) {
        $getUsers = User::readUser($token);
        
        return response()->json($getUsers);
    }

    public function saveUser($username, $email , $password) {
        $newUser = User::createUser($username, $email, $password);
        return response()->json($newUser);
    }

    public function deleteUser($username) {
        $deletedUser = User::deleteUser($username);

        return response()->json($deletedUser);
    }
    
    public function updateUser($token, $newPassword, $newUsername, $newEmail) {
        $users = User::updateUser($token, $newPassword, $newUsername, $newEmail);
        
        return response()->json($users);
    }

    // Get user id
    public function GetUserID($userToken){
      return response()->json(User::GetUserID($userToken));
    }
    
    //auth user
    public function authUser($username, $password) {
        $auth = User::authUser($username, $password);
        
        return response()->json($auth);
    }

}
