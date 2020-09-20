<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tag;
class TagController extends Controller
{
    public function getTags()
    {
        $tagArray = [
            1,2,3,4,5
        ];
        $tags = Tag::whereIn('id',$tagArray)->get();
        return response()->json([
            'tags' => $tags,
        ]);
    }
}
