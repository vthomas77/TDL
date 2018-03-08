<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // Create Category
    public function CreateCategory($categoryname,$categorycolor)
    {
        return response()->json(category::CreateCategory($categoryname,$categorycolor));
    }

}
