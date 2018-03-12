<?php

namespace App;
//use DB;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Task extends Model 
{

    static public function createTask($token, $taskName, $rank, $idCard){

        try {
            DB::table('tasks')->insert([
                'id_task' => NULL,
                'title' => $taskName,
                'rank' => $rank,
                'cards_id_card' => $idCard
            ]);
            
            //get idTask
            $idTask = DB::select('SELECT id_task FROM tasks WHERE title="' . $taskName . '" AND cards_id_card=' . $idCard);

            $dataTable = [
                'idTask' => $idTask,
                'title' => $taskName,
                'rank' => $rank, 
                'idCard' => $idCard
            ];
            
            return $dataTable;
        }
        //return status 500 if input username or email already exist in db
        catch(\Illuminate\Database\QueryException $e) {
            $dataTable = [
                'status' => 500,
                'type' => 'query exception'
            ];

            return $dataTable;
        }
    }
    
    static public function dropTask($token, $idTask) {
        
        DB::select('DELETE FROM tasks WHERE id_task=' . $idTask . ' LIMIT 1');
        
        return $idTask;
        
    }
    
    static public function readTask($token, $idCard) {
                
        return DB::select('SELECT id_task, title, cards_id_card FROM tasks WHERE cards_id_card=' . $idCard);
        
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
