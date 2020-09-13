<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Follow;

class FollowsController extends Controller
{
    public function index(Request $request)
    {
        $follows = Follow::select('*')->with(['member'])->get();
        return response()->json([
            // 'follows' => "成功",
            'follows' => $follows,
        ], 200);
    }
    public function show(Request $request, $id)
    {
        $follow_count = Follow::where('to_member_id', $id)->count();
        $is_follow = Follow::where('to_member_id', $id)->where('from_member_id', $request->input('from_member_id'))->first();

        if (!empty($is_follow)) {
            return response()->json([
                'follow_count' => $follow_count,
                'is_follow' => true,
            ]);
        }
        return response()->json([
            'follow_count' => $follow_count,    
            'is_follow' => false,
        ], 200);
    }
    public function destroy(Request $request, $id)
    {
        Follow::where('to_member_id', $id)->where('from_member_id', $request->input('from_member_id'))->delete();
        return response()->json([
            'test' => 'delete_success',
        ], 200);
    }

    public function store(Request $request)
    {
        $follows = Follow::where('from_member_id', $request->input('from_member_id'))->where('to_member_id', $request->input('to_member_id'))->first();
        if (empty($follows->id)) {
            $follows = new Follow();
        }
        $follows->from_member_id = $request->input('from_member_id');
        $follows->to_member_id = $request->input('to_member_id');
        $follows->save();

        $follow_count = Follow::where('to_member_id', $request->input('to_member_id'))->count();

        return response()->json([
            'test' => 'success',
            'follow_count' => $follow_count,
      
        ], 200);
    }
}
