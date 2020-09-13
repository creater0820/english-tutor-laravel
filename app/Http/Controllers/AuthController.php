<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rule;
use App\Model\Member;
use App\Model\User;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, Rule::memberStoreRules('login'), Rule::memberStoreMessages());
        $user = User::where('email', $request->input('email'))->first();
        if (empty($user->id)) {
            return response()->json([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], 404);
        }
        if (Crypt::decrypt($user->password) === $request->input(('password'))) {
            Auth::login($user, true);
            return response()->json([
                'token' => $user->remember_token,
            ], 200);
        }
        return response()->json([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'token' => $user->remember_token,
        ], 404);
    }
    public function isLogin(Request $request)
    {
        if(empty($request->input('remember_token'))){
            return response()->json([], 404);
        }
        $user = User::where('remember_token', $request->input('remember_token'))->first();
        if ($user) {
            return response()->json([
                'success' => "ログイン中",
            ], 200);
        }
        return response()->json([], 404);
    }
    public function getMemberId(Request $request)
    {
        if(empty($request->input('remember_token'))){
            return response()->json([], 404);
        }
        $user = User::where('remember_token', $request->input('remember_token'))->with(['member'])->first();
        if (!empty($user->member)) {
            return response()->json([
                'member_id' => $user->member->id,
            ], 200);
        }
        return response()->json([], 404);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'success' => "ログアウト成功",
        ], 200);

    }
}
