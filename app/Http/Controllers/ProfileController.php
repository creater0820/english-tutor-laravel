<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Member;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index()
    {
        $member = Member::where('id', Auth::login('id'));
        // if (!empty($request->input(('from_at')))) {
        //     $member->where('created_at', '>', $request->input('from_at'));
        // }
        $result = $member->get();
        return response()->json([
            'members' => $result,
            'test' => "テスト",
        ], 200);
    }
}
