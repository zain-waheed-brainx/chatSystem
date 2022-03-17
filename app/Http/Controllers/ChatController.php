<?php

namespace App\Http\Controllers;

use App\Message;
use App\Thread;
use App\User;
use App\UserThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function chatList()
    {
        $id = Auth::id();

        $user = User::with(['thread.thread.threadUsers' => function ($query) use ($id) {
            $query->where('user_id', '!=', $id)->get();
        }])->where('id', $id)->first();
        $list = $user->thread->map(function ($list) {
            $array = $list->toArray();
            return [
                'thread_id' => $array['thread_id'],
                'name' => $array['thread']['name']? $array['thread']['name'] : $array['thread']['thread_users'][0]['name'],
            ];
        });
        return response()->json(['data'=>$list]);
    }
    public function messageList($id)
    {
        $messages = Message::where('thread_id',$id)->get();
        return response()->json(['data'=>$messages]);
    }
    public function userList(Request $request)
    {
        $users = User::where('id','!=',Auth::id())->get();
        return response()->json(['data'=>$users]);
    }
    public function sendMessage(Request $request)
    {
        $message = New Message;
        $message->text = $request->text;
        $message->thread_id = $request->thread_id;
        $message->from = Auth::id();
        $message->save();
        return response()->json(['data'=>$message->toArray()]);
    }
    public function createGroup(Request $request)
    {
        $thread = New Thread();
        $thread->name = $request->name;
        $thread->type = 'group';
        $thread->save();
        foreach ($request->selectedValue as $user_id)
        {
            $threadUser = New UserThread;
            $threadUser->user_id = $user_id;
            $threadUser->thread_id = $thread->id;
            $threadUser->save();
        }
        $threadUser = New UserThread;
        $threadUser->user_id = Auth::id();
        $threadUser->thread_id = $thread->id;
        $threadUser->save();



        return response()->json(['data'=>$thread]);
    }
}
