<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('member/id','AuthController@getMemberId');
Route::post('member/{id}/set_profile_image','MemberController@setProfileImage');
Route::get('member/popular','MemberController@popularTeacherShow');
Route::apiResource('member','MemberController');
Route::get('contracts/new','ContractController@new');
Route::post('login','AuthController@login');
Route::get('login/check','AuthController@isLogin');
Route::get('logout','AuthController@logout');
Route::apiResource('plan','PlanController');
Route::apiResource('studentplan','StudentPlanController');
Route::get('getplan','PlanController@getPlan');
Route::get('getstudentplan','StudentPlanController@getStudentPlan');
Route::get('getsearchresults','StudentPlanController@getStudentplanFromTag');
// Route::post('follows','FollowsController');
Route::apiResource('follows','FollowsController');
Route::apiResource('profile','ProfileController');
Route::apiResource('message','MessageController');
Route::get('plan/lesson/{id}','PlanController@getLessons');
Route::get('categories','CategoryController@getCategories');
Route::get('tags','TagController@getTags');
