<?php

namespace App;

use DB;

class Category {

  // Create Category + Properties + Logs
  static public function CreateCategory ($categoryname,$categorycolor){

    // Insert category into database
    try {
      $resCreateCategory = DB::table('categories')->insertGetId(
        ['name' => $categoryname,
         'color' => $categorycolor]
      );
    } catch (\Exception $e) {
      return "1";
    }

  }

}
