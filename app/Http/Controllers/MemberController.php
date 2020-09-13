<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Member;
use App\Model\MemberTag;
use App\Model\Tag;
use App\Model\Plan;
use App\Model\PlanTag;
use App\Model\StudentPlanTag;
use App\Model\StudentPlan;
use App\Model\User;
use Illuminate\Support\Facades\Crypt;
use App\Rule;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::select('*');
        if (!empty($request->input(('from_at')))) {
            $member->where('created_at', '>', $request->input('from_at'));
        }
        $result = $member->get();
        return response()->json([
            'members' => $result,
            'from_at' => $request->input('from_at'),
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, Rule::memberStoreRules('create'), Rule::memberStoreMessages());
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $encrypted = Crypt::encrypt($request->input('password'));
        $user->password = $encrypted;
        $user->save();

        $member = new Member();
        $member->name = $request->input('name');
        $member->user_id = $user->id;
        // $member->address = "";
        $member->profile = "";
        $member->language_type = 0;
        $member->educational_background = "";
        $member->qualification = "";
        $member->icon = "";
        // $member->picture = "";
        // $member->image = $request->input('image');
        $member->save();
        Auth::login($user, true);

        $tags = $request->input('tags');

        foreach ($tags as $tag) {
            $insert[] = [
                'member_id' => $member->id,
                'tag_id' => $tag,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        MemberTag::insert($insert);

        return response()->json([], 200);
    }

    public function show($id)
    {
        $member = Member::where('id', $id)->with(['user'])->first();

        return  response()->json([
            'member' => $member,
            // 'education_background' => "",
            // 'language_type' => "",
            // 'qualification' => "",
            // 'icon' => "",
        ], 200);
    }
    // public function popularTeacherShow(Request $request)
    // {
    //     $popular_members = $request->input('member_id_array');
    //     if (!empty($popular_members)) {
    //         $popular_members_array = Member::whereIn('id', $popular_members)->with(['user'])->get();
    //     }
    //     return  response()->json([
    //         'popular_members_array' => $popular_members_array,
    //         'popular_members' => $popular_members,
    //     ], 200);
    // }
    public function popularTeacherShow(Request $request)
    {
        $memberTags = MemberTag::where('member_id', $request->input(('from_member_id')))->pluck('tag_id')->toArray();

        $memberId = Plan::whereExists(function ($q) use ($memberTags) {
            $q->select('plans.id')->from('plan_tags')->whereColumn('plans.id', '=', 'plan_tags.plan_id')->whereIn('plan_tags.tag_id', $memberTags);
        })->pluck('member_id')->toArray();

        // $planIds = PlanTag::whereIn('tag_id', $memberTags)->pluck('plan_id')->toArray();
        // $memberId = Plan::whereIn('id', $planIds)->pluck('member_id')->toArray();
        $reccomendTeachers = Member::whereIn('id', $memberId)->limit(9)->get();

        return  response()->json([
            'reccomend_teachers' => $reccomendTeachers,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // return response()->json([
        //     'name' => $request->input('name'),
        // ], 200);
        $this->validate($request, Rule::memberStoreRules('update'), Rule::memberStoreMessages());

        $member = Member::find($id);
        $member->name = $request->input('name');
        $member->profile = $request->input('profile');
        $member->language_type = $request->input('language_type');
        $member->qualification = $request->input('qualification');
        $member->educational_background = $request->input('educational_background');
        $member->save();

        $user = User::where('id', $member->user_id)->first();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json(['success' => '保存しました'], 200);
    }
    public function setProfileImage(Request $request, $id)
    {

        $member = Member::find($id);
        $file_name = $request->file('icon')->getClientOriginalName();
        $request->file('icon')->storeAs('public/images', $file_name);
        $member->icon = '/storage/images/' . $file_name;
        $member->save();
        return response()->json([], 200);
    }
    public function destroy($id)
    {
    }
}
