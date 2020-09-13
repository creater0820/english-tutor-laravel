<?php

namespace App\Http\Controllers;

use App\Model\Member;
use Illuminate\Http\Request;
use App\Model\Message;
use App\Model\MessageExchange;

class MessageController extends Controller
{
    public function index(Request $request)
    {
   
    }

    public function store(Request $request) {
        $message = new Message();
        $message->to_member_id = $request->input('to_member_id');
        $message->from_member_id = $request->input('from_member_id');
        $message->text = $request->input('text');
        $message->save();

        // insertとupdateを両方カバーした書き方
       $message_exchange = MessageExchange::where('member_id',$request->input('from_member_id'))->where('exchange_member_id',$request->input('to_member_id'))->first();
       if(empty($message_exchange->id)){
           $message_exchange=new MessageExchange();
       }
       $message_exchange->member_id = $request->input('from_member_id');
       $message_exchange->exchange_member_id = $request->input('to_member_id');
       $message_exchange->current_message = $request->input('text');
       $message_exchange->save();
       
       $message_exchange = MessageExchange::where('member_id',$request->input('to_member_id'))->where('exchange_member_id',$request->input('from_member_id'))->first();
       if(empty($message_exchange->id)){
           $message_exchange=new MessageExchange();
       }
       $message_exchange->member_id = $request->input('to_member_id');
       $message_exchange->exchange_member_id = $request->input('from_member_id');
       $message_exchange->current_message = $request->input('text');
       $message_exchange->save();
    }

    public function show(Request $request,$id)
    {
        // メッセージのやりとり
        $messages = Message::whereIn('from_member_id', [$id,$request->input('to_member_id')])->whereIn('to_member_id', [$id,$request->input('to_member_id')])->with(['member'])->orderBy('created_at', 'desc')->get();

        // メッセージ一覧
        $message_exchange = MessageExchange::where('member_id',$id)->with(['member'])->get();
      

        return response()->json([
            'messages' => $messages,
            'message_exchange' => $message_exchange,
        ], 200);
    }
}
