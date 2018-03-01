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
    public function showCard()
    {
        $MyCard = new Card("Carte1","","","","");
        return $MyCard->name;
    }

    //
}
