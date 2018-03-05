<?php

namespace App;

use DB;
use App\User;

class Card {

  // Create Card + Properties + Logs
  static public function CreateCard ($userID,$title,$priority,$status,$deadline,$category){

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
      $userID = user::GetUserID($userToken);
      $resGetCards = DB::table('properties')
        ->select('cards_id_card')
        ->where('users_id_user','=',$userID)
        ->get();
      $cardsCollection = [];
      foreach($resGetCards as $key => $value){
        $cardID = $value->cards_id_card;
        $cardsCollection[] = $cardID;
      }
      $cardsPropertiesCollection = [];
      foreach($cardsCollection as $cc){
        $resGetCardsProperties = DB::table('cards')
          ->select('title','priority','status','deadline','category')
          ->where('id_card','=',$cc)
          ->get();
          foreach($resGetCardsProperties as $key => $value){
            $cardsPropertiesCollection[] = $value;
          }
      }
      return $cardsPropertiesCollection;
    } catch (\Exception $e) {
      return "4";
    }
  }

}
