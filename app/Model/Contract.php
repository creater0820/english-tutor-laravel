<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $appends = ['diff_in_minutes'];
    protected $table = 'contracts';
    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'member_id'
        );
    }
    public function plan()
    {
        return $this->hasOne(
            'App\Model\Plan',
            'id',
            'plan_id'
        );
    }
    public function getDiffInMinutesAttribute(){
        // return $this->memberName()->created_at;
        //差分のcreated_atを取得
        return Carbon::now()->diffInMinutes($this->created_at);


        // $difference = Carbon::now()->diffInMinutes($this->created_at);
        // if ($difference < 60) {
        //     $differenceMinutes = $difference;
        //     return $differenceMinutes;
        // } elseif ($difference > 60) {
        //     $differenceHours = round($difference % 60);
        //     return $differenceHours;
        // }
    }
}
