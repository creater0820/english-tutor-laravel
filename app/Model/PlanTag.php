<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PlanTag extends Model
{
    public static function getPlanTag($tagId)
    {
        return self::whereIn('tag_id', $tagId);
    }
}
