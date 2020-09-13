<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MessageExchange extends Model
{
    protected $table = 'message_exchanges';
    protected $appends =['diff_in_minutes'];
    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'exchange_member_id'
        );
    }
    public function getDiffInMinutesAttribute(){
        return Carbon::now()->diffInMinutes($this->created_at);
    }
}
