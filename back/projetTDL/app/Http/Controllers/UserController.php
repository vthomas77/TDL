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

    public function saveUser($username, $email , $password, $avatar) {
        $newUser = User::createUser($username, $email, $password, $avatar);
        return response()->json($newUser);
    }

    public function deleteUser($username, $token) {
        $deletedUser = User::deleteUser($username);
        $checkToken = User::eachAdmin($token);

        return response()->json([$deletedUser, $checkToken]);
    }

    public function updateUser($token, $newPassword, $newUsername, $newEmail, $updateAvatar) {
        $users = User::updateUser($token, $newPassword, $newUsername, $newEmail, $updateAvatar);

        return response()->json($users);
    }

    // Get user id
    public function GetUserID($userToken){
      return response()->json(User::GetUserID($userToken));
    }

    // Search users
    public function SearchUsers($searchInput){
      return response()->json(User::SearchUsers($searchInput));
    }

    // Upload avatar
    public function UploadImg(Request $request){
      $sourcePath = $_FILES['myFile']['tmp_name'];
      $targetPath = "./".$_FILES['myFile']['name'];
      move_uploaded_file($sourcePath,$targetPath) ;
      return $targetPath;
    }

    //auth user
    public function authUser($username, $password) {
        $auth = User::authUser($username, $password);

        return response()->json($auth);
    }

}
