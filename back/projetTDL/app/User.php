<?php

namespace App;
//use DB;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function hasToken($token)
    {
        return DB::table('users')
              ->select('token')
              ->where('token','=',$token)
              ->get();
    }

    // Get user ID from token in Database
    static public function GetUserID ($userToken){
      try {
        $resGetUserID = DB::table('users')
          ->select('id_user')
          ->where('token','=',$userToken)
          ->get();
        return $resGetUserID[0]->id_user;
      } catch (\Exception $e) {
        return 'error';
      }
    }

    // Get user ID from username in Database
    static public function GetUserIDFromUsername ($username){
      try {
        $resGetUserIDFromUsername = DB::table('users')
          ->select('id_user')
          ->where('username','=',$username)
          ->get();
        return $resGetUserIDFromUsername[0]->id_user;
      } catch (\Exception $e) {
        return 'error';
      }
    }

    // Get user avatar from user_id in database
    static public function GetUserAvatar ($userID){
      try {
        $resGetUserAvatar = DB::table('users')
          ->select('avatar')
          ->where('id_user','=',$userID)
          ->get();
        return $resGetUserAvatar[0]->avatar;
      } catch (\Exception $e) {
        return 'error';
      }
    }

    // Search users
    static public function SearchUsers ($searchInput){
      try {
        $searchUsername = $searchInput . '%';
        $resSearchUsers = DB::table('users')
          ->select('username')
          ->where('username','like',$searchUsername)
          ->get();
        return $resSearchUsers;
      } catch (\Exception $e) {
        return 'error';
      }
    }

    //might be unecessary
    public function __construct($username, $email, $avatar, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->password = $password;
    }


    static public function createUser($username, $email , $password, $avatar){

        //$avatar = "./assets/img/default.png";
        $token = bin2hex(random_bytes(20));
        //token lifetime is 5 hours after yet  (considering our 1h less thing, it's more like 4h for France)
        $token_expiration = time() + 18000;

        try {
            DB::table('users')->insert([
                'id_user' => NULL,
                'username' => $username,
                'email' => $email,
                'avatar' => $avatar,
                'password' => $password,
                'token' => $token,
                'token_expiration' => $token_expiration
            ]);

            $dataTable = [
                'token' => $token,
                'expiration' => $token_expiration,
                'username' => $username,
                'status' => 200
            ];

            return $dataTable;
        }
        //return status 500 if input username or email already exist in db
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
        catch(\Exception $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
    }

    static public function updateUser($token, $newPassword, $newUsername, $newEmail, $updateAvatar) {
        //
        try {
            DB::table('users')
                ->where([
                    ['token', '=', $token],
                ])->update(array(
                    'username' => $newUsername,
                    'password' => $newPassword,
                    'email' => $newEmail, 
					'avatar' => $updateAvatar
                ));

            $dataTable = [
                'username' => $newUsername,
				'avatar'=> $updateAvatar,
                'status' => 200
            ];

            return $dataTable;
        }
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
        catch(\Exception $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
    }

    static public function deleteUser($username) {

        try {

            DB::table('users')
                ->where([
                    ['username', '=', $username],
                ])->delete();

            //$deletedUsers = User::find($username);
            //$deletedUsers->delete();

            $dataTable = [
                'status' => 200
            ];

            return $dataTable;
        }
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
        catch(\Exception $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
    }

    static public function readUser($token) {

        try {
            $res = DB::table('users')
              ->select('username', 'email', 'avatar')
              ->where('token','=',$token)
              ->get();

            return $res;
        }
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
        catch(\Exception $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }

    }

    static public function authUser($username, $password) {

        try {
            $res = DB::table('users')
              ->select('username', 'avatar', 'token')
              ->where([
                    ['username', '=', $username],
                    ['password', '=', $password],
                ])
              ->get();

            $dataTable = [
                'res' => $res,
                'status' => 200
            ];

            return $res;
        }
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
        catch(\Exception $e) {
            $dataTable = [
                'status' => 500
            ];

            return $dataTable;
        }
    }
}
