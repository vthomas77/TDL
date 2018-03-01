<?php

namespace App;

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
    
    //might be unecessary
    public function __construct($username, $email, $avatar, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->password = $password;
    }
    
    static public function CreateUser($username, $password, $email){
        
        //put some if here to test avatar existance
        //if not, initialize avatar to NULL
        $avatar = "avrrowowowooowaaaaaar";
        
        DB::table('users')->insert([
            'id_user' => NULL,
            'username' => $username,
            'email' => $email,
            'avatar' => $avatar,
            'password' => $password,
            //still need to be randomly generated
            'token' => 'ezr157fersadzhnv0cd', 
            'token_expiration' => '09.11.19'
        ]);
        
        //$render = DB::select('SELECT username FROM users WHERE username="' + $username + '"');
        return $username;
    }
}
