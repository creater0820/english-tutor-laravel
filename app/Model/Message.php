<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $appends = ['diff_in_minutes'];

    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'from_member_id'
        );
    }

    public function getDiffInMinutesAttribute(){
        return Carbon::now()->diffInMinutes($this->created_at);
    }
}
