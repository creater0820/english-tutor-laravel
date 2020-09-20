<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeacherPlanTag extends Model
{
    public static function getTeacherPlanId($tagId)
    {
        return self::whereIn('tag_id', $tagId);
    }
    public function tag()
    {
        return $this->hasOne(
            'App\Model\Tag',
            'id',
            'tag_id'
        );
    }

}
