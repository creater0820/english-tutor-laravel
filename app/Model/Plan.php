<?php

namespace App\Model;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $appends = ['diff_in_minutes'];
    protected $table = 'plans';
    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'member_id',
        );
    }
    public function getDiffInMinutesAttribute(){
        return Carbon::now()->diffInMinutes($this->created_at);
    }
}
