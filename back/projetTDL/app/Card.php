<?php

namespace App;

use DB;

class Card {

  // Insert card into database
  static public function CreateCard ($title,$priority,$status,$deadline,$category){
    try {
      $resCreateCard = DB::table('cards')->insert(
        ['title' => $title,
         'priority' => $priority,
         'status' => $status,
         'deadline' => $deadline,
         'category' => $category]
      );
      return $resCreateCard;
    } catch (\Illuminate\Database\QueryException $e){
      if ($e->getCode() == 23000){
        $resCreateCard = "Ce nom de carte existe déjà";
      }
      return $resCreateCard;
    }
  }

}
