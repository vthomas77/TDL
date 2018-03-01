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
    
    //add in function arg : Request $request
    public function saveUser() {
        $newUser = BD::table('users')->insert([
            'id_user' => NULL,
            'username' => 'Christine',
            'email' => 'the@queen.com',
            'avatar' => 'http://myimgurl.com',
            'password' => 'and',
            'token' => 'f5zJJdf5z88De5a6d6fiizDse2E6ty3h0cd', 
            'token_expiration' => '12.12.12'
        ]);
        return response()->json('new user added');
        
        //$users = User::create($request->all());
        //return response()->json($users);
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
}