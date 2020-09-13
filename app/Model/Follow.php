<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';
    public function member()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'to_member_id'
            // ここを１と見て相手から何個とれるかでhasMany,hasOneを判断する
        );
    }
}
