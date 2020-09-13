<?php

namespace App\Http\Controllers;

use App\Model\Contract;
use Illuminate\Http\Request;
use App\Model\Plan;
use App\Model\User;
use Carbon\Carbon;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $contract = Contract::select('*');
        $fewHoursAgo = Carbon::now()->subHours(360000);
        $newPlans = $contract->with(['member', 'plan'])->where('created_at', '>', $fewHoursAgo)->orderBy('created_at', 'desc')->get();

        // $differenceTime = $now->diffInMinutes($newPlans->created_at);
        // $differenceTime = $now->diffInMinutes();
        // $time = $now-$fewHoursAgo;
        return response()->json([
            'newPlans' => $newPlans,
            'carbon' => $fewHoursAgo,
            'image' => [

                "http://127.0.0.1:8001/image/shutterstock_602226047.png",
                "http://127.0.0.1:8001/image/shutterstock_718228894.png",
                "http://127.0.0.1:8001/image/shutterstock_1708564030.png",
                "http://127.0.0.1:8001/image/shutterstock_602226047.png",

            ],
            // 'differenceTime' => $differenceTime,
            // 'memberName' => $memberName,
        ], 200);
    }
    public function store(Request $request)
    {
        if (!empty($request->input('token'))) {
            $user = User::where('remember_token', $request->input('token'))->with(['member'])->first();
            if (!empty($user->member->id)) {
                $plan = new plan();
                $plan->title = $request->input('title');
                $plan->content = $request->input('content');
                $plan->category_type = $request->input('category_type');
                // $plan->english_category = $request->input('english_category');
                $plan->amount = $request->input('amount');
                $plan->member_id = $user->member->id;
                $plan->save();
            }
        }
        if (!empty($request->input('categories')) && !empty($plan->id)) {
        }
        if (!empty($request->input('tags'))  && !empty($plan->id)) {
        }
        return response()->json([], 200);
    }
    public function getPlan(Request $request)
    {
        $fewHoursAgo = Carbon::now()->subHours(360000);
        $newPlans = Plan::with(['member'])->where('created_at', '>', $fewHoursAgo)->orderBy('created_at', 'desc')->limit(4)->get();
        return response()->json([
            'new_plans' => $newPlans
        ], 200);
    }

    public function getLessons($id)
    {
        $give_plans = Plan::where('member_id', $id)->get();
        $take_plans = Contract::where('member_id', $id)->with(['plan'])->get();

        return response()->json([
            'give_plans' => $give_plans,
            'take_plans' => $take_plans,
        ], 200);
    }
}
