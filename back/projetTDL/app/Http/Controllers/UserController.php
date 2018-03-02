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
    
    public function updateUser($username, $password, $newPassword, $newUsername, $newEmail) {
        $users = User::updateUser($username, $password, $newPassword, $newUsername, $newEmail);
        
        return response()->json($users);
    }
}