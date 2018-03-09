<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // Create Card
    public function CreateCard($userToken,$title,$priority,$category,$deadline,$status)
    {
        return response()->json(card::CreateCard($userToken,$title,$priority,$status,$deadline,$category));
    }

    // Get Card
    public function GetCard($userToken)
    {
        return response()->json(card::GetCard($userToken));
    }

    // Delete Card
    public function DeleteCard($userToken,$cardID)
    {
        return response()->json(card::DeleteCard($userToken,$cardID));
    }

    // Share Card
    public function ShareCard($cardID)
    {
        return response()->json(card::ShareCard($cardID));
    }

    // Update Collaborators
    public function UpdateCollaborators(Request $request)
    {
        $newCardCollaborators = $request->json()->all();
        $cardID = $newCardCollaborators['idcard'];
        $cardCollaborators = $newCardCollaborators['usernames'];
        return response()->json(card::UpdateCollaborators($cardID,$cardCollaborators));
    }

}
