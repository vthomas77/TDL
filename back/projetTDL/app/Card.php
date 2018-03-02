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
    } catch (\Exception $e) {
      return "An error occured";
    }
  }

}
