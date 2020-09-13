<?php

namespace App\Http\Controllers;

use App\Model\Member;
use Illuminate\Http\Request;
use App\Model\Plan;
use App\Model\User;
use App\Model\StudentPlanTag;
use App\Model\MemberTag;
use App\Model\Tag;
use App\Model\StudentPlan;
use App\Model\PlanTag;
use Carbon\Carbon;


class StudentPlanController extends Controller
{
    public function index(Request $request)
    {
        $fewHoursAgo = Carbon::now()->subHours(360000);
        $plan = StudentPlan::getStudentPlan($request)->get();

        $memberTags = MemberTag::where('member_id', $request->input(('from_member_id')))->pluck('tag_id')->toArray();
        // todo取れない
        // $memberTags = MemberTag::getMemberTag($request);

        $studentPlanTags = StudentPlanTag::whereIn('tag_id', $memberTags)->pluck('studentplan_id');
        $studentPlans = StudentPlan::whereIn('id', $studentPlanTags)->with(['member', 'studentPlanTags', 'studentPlanTags.tag'])->where('created_at', '>', $fewHoursAgo)->orderBy('created_at', 'desc')->limit(6)->get();

        return response()->json([
            'plan' => $plan,
            'student_plans' => $studentPlans,
        ], 200);
    }

    public function getStudentPlan(Request $request)
    {
        $fewHoursAgo = Carbon::now()->subHours(360000);

        $memberTags = MemberTag::where('member_id', $request->input(('from_member_id')))->pluck('tag_id')->toArray();
        // todo取れない
        // $memberTags = MemberTag::getMemberTag($request);

        $studentPlanTags = StudentPlanTag::whereIn('tag_id', $memberTags)->pluck('studentplan_id');
        $studentPlans = StudentPlan::whereIn('id', $studentPlanTags)->with(['member', 'studentPlanTags', 'studentPlanTags.tag'])->where('created_at', '>', $fewHoursAgo)->orderBy('created_at', 'desc')->limit(6)->get();

        return response()->json([
            'student_plans' => $studentPlans,
        ], 200);
    }
    public function show(Request $request, $id)
    {
        $fewHoursAgo = Carbon::now()->subHours(360000);
        $studentPlan = StudentPlan::with(['member'])->where('member_id', $request->input('to_member_id'))->get();
        // todo requestの値が取れないので次の行で便宜的に20を使用中
        $plan = StudentPlan::where('id', 20)->get();
        // $plan = StudentPlan::where('id',$request->input('plan_id'))->get();
        // $studentPlan = StudentPlan::with(['member'])->where('member_id',$request->input('to_member_id'))->get();
        return response()->json([
            'student_plan' => $studentPlan,
            'request' => $request,
            'id' => $id,
            'plan' => $plan,
        ], 200);
    }
    public function store(Request $request)
    {
        if (!empty($request->input('token'))) {
            $user = User::where('remember_token', $request->input('token'))->with(['member'])->first();
            if (!empty($user->member->id)) {
                $studentPlan = new StudentPlan();
                $studentPlan->title = $request->input('title');
                $studentPlan->content = $request->input('content');
                $studentPlan->category_type = $request->input('category_type');
                // $studentPlan->english_category = $request->input('english_category');
                $studentPlan->amount = $request->input('amount');
                $studentPlan->member_id = $user->member->id;
                $studentPlan->save();
            }
        }
        if (!empty($request->input('categories')) && !empty($studentPlan->id)) {
        }
        if (!empty($request->input('tags'))  && !empty($studentPlan->id)) {
            $tagsData = $request->input('tags');
            $insert = [];
            foreach ($tagsData as $tagData) {
                $insert[] = [
                    'tag_id' => $tagData,
                    'studentplan_id' => $studentPlan->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            StudentPlanTag::insert($insert);

            // $tagName = [];
            // switch($tagData){
            //     case "1":
            //         $tagName[] = "簿記";
            //     case "2":
            //         $tagName[] = "税理士";
            //     case "3":
            //         $tagName[] = "行政書士";
            //     case "4":
            //         $tagName[] = "司法書士";
            //     case "5":
            //         $tagName[] = "宅地建物取引士";
            //     case "6":
            //         $tagName[] = "弁護士";
            //     case "6":
            //         $tagName[] = "社会保険労務士";
            // }
        }
        return response()->json([], 200);
    }

    public function getStudentPlanFromTag(Request $request)
    {
        $tag = Tag::getTagId($request)->get();
        $planTag = PlanTag::getPlanTag($tag)->pluck('plan_id')->toArray();
        $searchResults =  StudentPlan::getPlan($planTag)->get();
        return response()->json([
            'search_results' => $searchResults,
        ], 200);
    }
}
