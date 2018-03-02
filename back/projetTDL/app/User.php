<?php

namespace App;
use DB;

use Illuminate\Auth\Authenticatable;
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
        return "1";
      }
    }

}
