<?php

namespace App\Http\Controllers;

use App\Card;

class CardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // Create Card
    public function CreateCard($userID,$title,$priority,$category,$deadline,$status)
    {
        return response()->json(card::CreateCard($userID,$title,$priority,$status,$deadline,$category));
    }

    // Get Card
    public function GetCard($userToken)
    {
        return response()->json(card::GetCard($userToken));
    }

}
