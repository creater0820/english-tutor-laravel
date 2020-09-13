<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tag extends Model
{
    public static function getTagId(Request $request){
        return self::whereIn('id',$request->input('tag_id'));
    }
}
