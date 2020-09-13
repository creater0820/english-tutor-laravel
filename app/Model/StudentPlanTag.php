<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentPlanTag extends Model
{
    protected $appends = ['tag_name'];
    protected $table = 'student_plan_tags';

    public function tag()
    {
        return $this->hasOne(
            'App\Model\Tag',
            'id',
            'tag_id'
        );
    }

    public function getTagNameAttribute()
    {
        if ($this->tag) {
            return $this->tag->name;
        }
        return '';
    }
}
