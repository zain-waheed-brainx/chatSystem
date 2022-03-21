<?php

namespace App\Http\Controllers;

use App\Message;
use App\Thread;
use App\User;
use App\UserThread;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    public function chatList()
    {
        $id = Auth::id();

        $thread = Thread::with(['latestMessage'=> function ($query) use ($id) {
            $query->orderBy('created_at','desc');
        },'otherUser'=> function ($query) use ($id) {
            $query->where('user_id', '!=', $id)->get();
        },'otherUser.user',])->whereHas('threadUsers',function ($query)  use ($id){
            $query->where('user_id', '=', $id);
        })->get()->map(function ($list) {
            $message = $list->latestMessage;
            if ($message)
            {
                $time = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('d-m-Y g:i A');
                $text = Str::limit($message->text,30);
            }
            else
            {
                $time ='';
                $text = '';
            }

//            dd($time);
            return [
                'thread_id' => $list->id,
                'name' =>$list->name?$list->name:$list->otherUser->user->name,
                'message' => $text,
                'message_id' => $message?$message->id:0,
                'time' => $time
                ,
            ];
        });
        $thread = $thread->sortByDesc('message_id')->values()->all();
        return response()->json(['data'=>$thread]);
    }
    public function messageList($id)
    {
        $messages = Message::with('sender')->where('thread_id',$id)->get()->map(function ($msg) {
            return [
                'text' =>$msg->text,
                'sender' =>$msg->sender,
                'from' =>$msg->from,
                'time' =>Carbon::createFromFormat('Y-m-d H:i:s', $msg->created_at)->format('d-m-Y g:i A'),
            ];
        });
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
