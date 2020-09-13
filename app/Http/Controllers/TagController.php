<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tag;
class TagController extends Controller
{
    public function getTags()
    {
        $tags = Tag::get();
        return response()->json([
            'tags' => $tags,
        ]);
    }
}
