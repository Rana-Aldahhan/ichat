<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($id)
    {
        $messages=auth()->user()->getConversation($id);
        $messagedUser=User::find($id);
        return view('chat',['messages'=>$messages,'messagedUser'=>$messagedUser]);
    }
    public function store(Request $request,$id){
        $message=new Message();
         $message->body=request('body');
         $message->sender_id=auth()->user()->id;
         $message->receiver_id=$id;
         $message->save();
         $message->load(['sender','receiver']);
         broadcast(new NewMessage($message))->toOthers();
         return response()->json($message);
    }
}
