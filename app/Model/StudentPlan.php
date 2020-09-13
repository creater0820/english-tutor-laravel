<?php

namespace App\Model;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StudentPlan extends Model
{
    protected $appends = ['diff_in_minutes'];
    protected $table ='student_plans';
    public function member(){
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'member_id'
        );
    }
    public function category(){
        return $this->hasOne(
            'App\Model\Category',
            'id',
            'category_id'
        );
    }
    public function tag()
    {
        return $this->hasOne(
            'App\Model\Tag',
            'category_id',
            'category_type'
        );
    }
    public function studentPlanTag()
    {
        return $this->hasOne(
            'App\Model\StudentPlanTag',
            'studentplan_id',
            'id'
        );
    }
    public function studentPlanTags()
    {
        return $this->hasMany(
            'App\Model\StudentPlanTag',
            'studentplan_id',
            'id'
        );
    }
  
    public function getDiffInMinutesAttribute(){
        return Carbon::now()->diffInMinutes($this->created_at);
    }
  
    public static function getStudentPlan(Request $request){
        return self::where('id', $request->input('plan_id'));
    }
    public static function getPlan($planTag){
        return self::whereIn('id', $planTag);
    }
    
}
