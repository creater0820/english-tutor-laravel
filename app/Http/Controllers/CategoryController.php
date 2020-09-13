<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;

class CategoryController extends Controller
{

    public function getCategories()
    {
        $category = Category::get();
        return response()->json([
            'categories' => $category,
        ]);
    }
}
