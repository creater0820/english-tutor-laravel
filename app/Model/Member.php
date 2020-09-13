<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Tag;
use Carbon\Carbon;
use App\Model\MemberTag;

class Member extends Model
{
    protected $table = 'members';
    protected $appends = ['tag_name', 'diff_in_minutes'];

    public function user()
    {
        return $this->hasOne(
            'App\Model\User',
            'id',
            'user_id',
        );
    }
    public function toMessage()
    {
        return $this->hasOne(
            'App\Model\Message',
            'to_member_id',
            'id',
        )->orderBy('created_at', 'desc');
    }
    public function fromMessage()
    {
        return $this->hasOne(
            'App\Model\Message',
            'from_member_id',
            'id',
        )->orderBy('created_at', 'desc');
    }

    public function getTagNameAttribute()
    {
        $memberTags = MemberTag::where('member_id', 22)->pluck('tag_id')->toArray();
        return Tag::whereIn('id', $memberTags)->pluck('name');
    }
    public function getDiffInMinutesAttribute()
    {
        return Carbon::now()->diffInMinutes($this->created_at);
    }
}
