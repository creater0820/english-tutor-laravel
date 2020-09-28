<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TeacherPlan;
use App\Model\TeacherPlanTag;
use App\Model\Tag;
use App\Model\User;
use Carbon\Carbon;
use App\Rule;

class TeacherPlanController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, Rule::validationRule('plan'), Rule::memberStoreMessages());
        if (!empty($request->input('token'))) {
            $user = User::where('remember_token', $request->input('token'))->with(['member'])->first();
            if (!empty($user->member->id)) {
                $teacherPlan = new TeacherPlan();
                $teacherPlan->title = $request->input('title');
                $teacherPlan->content = $request->input('content');
                $teacherPlan->amount = $request->input('amount');
                $teacherPlan->member_id = $user->member->id;
                $teacherPlan->save();
            }
            if (!empty($request->input('tags'))  && !empty($teacherPlan->id)) {
                $tagsData = $request->input('tags');
                $insert = [];
                foreach ($tagsData as $tagData) {
                    $insert[] = [
                        'tag_id' => $tagData,
                        'teacher_plan_id' => $teacherPlan->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
                TeacherPlanTag::insert($insert);
            }
        }
        return response()->json([], 200);
    }
    public function index(Request $request)
    {
        // $teacherPlanId = TeacherPlanTag::getTeacherPlanId($request->input('tag_id'))->pluck('teacher_plan_id')->toArray();
        // $teacherPlans = TeacherPlan::whereIn('id', $teacherPlanId)->orderBy('created_at', 'desc')->get();
        
        $teacherPlanId = TeacherPlanTag::getTeacherPlanId($request->input('tag_id'))->pluck(('teacher_plan_id'))->toArray();
        $paginatedTeacherPlans = TeacherPlan::getTeacherPlan($teacherPlanId)->with(['member','teacherPlanTags','teacherPlanTags.tag'])->orderBy('created_at', 'desc')->paginate(10,['*'],'page',$request->input('current_page'));

        return response()->json([
            'teacher_plans' => $teacherPlanId,
            'paginated_plans' => $paginatedTeacherPlans,
        ]);
    }
}
