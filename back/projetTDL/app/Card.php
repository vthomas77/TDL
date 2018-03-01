<?php

namespace App;

class Card {
  public function __construct($name,$category,$priority,$status,$deadline){
    $this->name = $name;
    $this->category = $category;
    $this->priority = $priority;
    $this->status = $status;
    $this->deadline = $deadline;
  }

  static public function CreateCard ($name,$category,$priority,$status,$deadline){
    $results = DB::select("SELECT * FROM cards");
  }
}
