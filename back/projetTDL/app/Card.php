<?php

namespace App;

use DB;
use App\User;

class Card {

  public function __construct($id,$title,$priority,$status,$deadline,$category,$rank,$collaborators, $tasks){
    $this->id = $id;
    $this->title = $title;
    $this->priority = $priority;
    $this->status = $status;
    $this->deadline = $deadline;
    $this->category = $category;
    $this->rank = $rank;
    $this->collaborators = $collaborators;
    $this->tasks = $tasks;
  }


  // Create Card + Properties + Logs
  static public function CreateCard ($userToken,$title,$priority,$status,$deadline,$category){

    $userID = user::GetUserID($userToken);
    // Insert card into database
    try {
      $resCreateCard = DB::table('cards')->insertGetId(
        ['title' => $title,
         'priority' => $priority,
         'status' => $status,
         'deadline' => $deadline,
         'category' => $category]
      );
    } catch (\Exception $e) {
      return "1";
    }

    // Get max rank from user's card
    try {
      $resGetUserCards = DB::table('properties')
        ->select('rank')
        ->where('users_id_user','=',$userID)
        //->where('cards_id_card','=',$resCreateCard)
        ->max('rank');

        if ($resGetUserCards == NULL){
          $rank = 1;
        } else {
          $rank = $resGetUserCards + 1;
        }
    } catch (\Exception $e) {
      return "2";
    }

    // Insert preferences into database
    try {
      $resCreatePreference = DB::table('properties')->insert(
        ['users_id_user' => $userID,
         'cards_id_card' => $resCreateCard,
         'rank' => $rank,
         'rights' => '',
         'filter_perso' => '',
         'filter_general' => '']
      );
    } catch (\Exception $e) {
      return "3";
    }

    // Insert logs into database
    try {
      $resCreateLog = DB::table('logs')->insert(
        ['users_id_user' => $userID,
         'cards_id_card' => $resCreateCard,
         'type' => 'Creation',
         'content' => 'Card',
         'date' => date('Y-m-d H:i:s')]
      );
      return "0";
    } catch (\Exception $e) {
      return "4";
    }

  }


// Get cards from user
static public function GetCard ($userToken){
    try {        
        
      $cardsProperties = [];
      $userID = user::GetUserID($userToken);
      $resGetCardsFromUser = DB::table('properties')
        ->join('cards', 'cards.id_card', '=', 'properties.cards_id_card')
        ->select('cards.id_card','cards.title','cards.priority','cards.status','cards.deadline','cards.category','properties.rank')
        ->where('properties.users_id_user','=',$userID)
        ->get();
      foreach ($resGetCardsFromUser as $key => $value)
      {
        $collaborators = [];
        $resGetCollabortorsFromCard = DB::table('properties')
          ->join('users', 'users.id_user', '=', 'properties.users_id_user')
          ->select('users.id_user','users.avatar')
          ->where('properties.cards_id_card','=',$value -> id_card)
          ->get();
        foreach ($resGetCollabortorsFromCard as $key => $v)
        {
          $collaborators[] = $v->avatar;
        }
          
        /*
        $tasks = [];
        $resTasks = DB::table('tasks')
            ->join('cards', 'cards.id_card', '=', 'tasks.cards_id_card')
            ->select('tasks.id_task', 'tasks.title', 'tasks.rank')
            ->where('tasks.cards_id_card', '=', $value => id_card)
            ->get();
        */
          
        $tasks = [];
        $resTasks = DB::table('cards')
            ->join('tasks', 'tasks.cards_id_card', '=', 'cards.id_card')
            ->select('tasks.id_task', 'tasks.title')
            ->where('tasks.cards_id_card', '=', $value -> id_card)
            ->get();
        
        foreach($resTasks as $key => $val) {
            $tasks[] = [$val->title, $val->id_task];
        }
            
        $cardsProperties[] = new Card(
         $value -> id_card,
         $value -> title,
         $value -> priority,
         $value -> status,
         $value -> deadline,
         $value -> category,
         $value -> rank,
         $collaborators,
         $tasks
        );
      }
    
      return $cardsProperties;

    } catch (\Exception $e) {
      return "4";
    }
  }

// Delete card
static public function DeleteCard ($userToken,$cardID){
  try {
    $userID = user::GetUserID($userToken);
    $resDeleteCardLogs = DB::table('logs')
    ->where('cards_id_card','=',$cardID)
    ->delete();
    $resDeleteCardAssociations = DB::table('properties')
    ->where('cards_id_card','=',$cardID)
    ->delete();
    $resDeleteCard = DB::table('cards')
    ->where('id_card','=',$cardID)
    ->delete();
    return $resDeleteCard;
  } catch (\Exception $e) {
    return "4";
  }
}

}
