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
    public function CreateCard($id_user,$title,$priority,$category,$deadline)
    {
        return response()->json(card::CreateCard("Carte5","1","en cours","2018-03-01 17:30:00","projet"));
    }

}
