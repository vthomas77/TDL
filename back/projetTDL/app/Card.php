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
}
