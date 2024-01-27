<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate(
            [
                'message' => 'required|max:1000',
                'receiver_id' => 'required|integer'
            ],
            [
                'message.required' => 'Ju lutem shkruani nje mesazh.'
            ]
        );

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        $avatar = auth()->user()->avatar;
        // dd($avatar);
        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, auth()->user()->id))->toOthers();
        \Log::info('Event broadcasted successfully' . $request->receiver_id);

        return response(['status' => 'Success', 'msgId' => $request->msg_temp_id]);
    }

    public function getConversation(string $senderId)
    {
        $receiverId = auth()->user()->id;

        Chat::where('sender_id' , $senderId)->where('receiver_id' , $receiverId)
        ->where('seen' , 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        return response($messages);
    }
}