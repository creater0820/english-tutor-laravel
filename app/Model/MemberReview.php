<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MemberReview extends Model
{
    public function review()
    {
        return $this->hasOne(
            'App\Model\Member',
            'id',
            'review_id',
        );
    }
}
