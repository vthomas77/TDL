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

    //might be unecessary
    public function __construct($username, $email, $avatar, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->password = $password;
    }

    static public function CreateUser($username, $email , $password){

        //put some if here to test avatar existance
        //if not, initialize avatar to a chosen generic link
        $avatar = "./assets/img/default.png";
        $token = bin2hex(random_bytes(20));

        try {
            DB::table('users')->insert([
                'id_user' => NULL,
                'username' => $username,
                'email' => $email,
                'avatar' => $avatar,
                'password' => $password,
                'token' => $token,
                'token_expiration' => '09.11.19'
            ]);

            $dataTable = [
                'token' => $token,
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
    }
}
