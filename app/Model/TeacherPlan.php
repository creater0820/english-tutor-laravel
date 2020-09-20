<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TeacherPlan extends Model
{
    protected $appends = ['diff_in_minutes'];
    public static function getTeacherPlan($tagId)
    {
        return self::whereIn('id', $tagId);
    }
    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'member_id'
        );
    }
    public function teacherPlanTags()
    {
        return $this->hasMany(
            'App\Model\TeacherPlanTag',
            'teacher_plan_id',
            'id'
        );
    }
    public function getDiffInMinutesAttribute()
    {
        return Carbon::now()->diffInMinutes($this->created_at);
    }
}
