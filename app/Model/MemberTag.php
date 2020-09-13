<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MemberTag extends Model
{
    public static function getMemberTag($request)
    {
        self::where('member_id', $request->input(('from_member_id')))->pluck('tag_id')->toArray();
    }
    public static function getPlanTag($request)
    {
        self::where('member_id', $request->input(('from_member_id')))->pluck('tag_id')->toArray();
    }
}
