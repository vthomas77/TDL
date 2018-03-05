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


    //might be unecessary
    public function __construct($username, $email, $avatar, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->password = $password;
    }

    
    static public function createUser($username, $email , $password){
        
        $avatar = "./assets/img/default.png";
        $token = bin2hex(random_bytes(20));
        $token_expiration = date('Y/m/d h:i:s', time() + 7200);

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
    }
    
    static public function updateUser($username, $password, $newPassword, $newUsername, $newEmail) {
        //
        try {
            DB::table('users')
                ->where([
                    ['username', '=', $username],
                    ['password', '=', $password],
                ])->update(array(
                    'username' => $newUsername,
                    'password' => $newPassword,
                    'email' => $newEmail
                ));
            
            $dataTable = [
                'username' => $newUsername,
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
    }
}
