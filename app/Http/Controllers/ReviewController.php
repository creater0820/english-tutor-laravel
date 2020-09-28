<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Review;
use App\Model\Member;
use App\Model\MemberReview;
use App\Rule;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, Rule::validationReview('review'), Rule::memberStoreMessages());
        if (!empty($request->input('from_member_id'))) {
            $review = new Review();
            $review->amount = $request->input('star');
            $review->content = $request->input('review');
            $review->from_member_id = $request->input('from_member_id');
            $review->save();
        }
        if (!empty($review->id)) {
            $memberReview = new MemberReview();
            $memberReview->member_id = $request->input('to_member_id');
            $memberReview->review_id = $review->id;
            $memberReview->save();
        }
    }
    public function showStarAmount()
    {
        $starAmount = Member::where('id', '1')->with(['memberReviews.review',])->get();
        return response()->json([
            'starAmount' => $starAmount,
        ], 200);
    }
}
