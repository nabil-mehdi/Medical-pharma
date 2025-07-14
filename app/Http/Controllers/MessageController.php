<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getConversation($userId, $otherUserId)
    {
        $messages = Message::where(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $otherUserId)
                ->where('receiver_id', $userId);
        })
            ->with(['sender:id,nom,prenom', 'receiver:id,nom,prenom'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function markAsRead($messageId, $userId)
    {
        $message = Message::findOrFail($messageId);

        // Attention : en base, receiver_id est probablement un entier, donc == ou === ne change rien ici
        if ($message->receiver_id == $userId) {
            $message->is_read = true;
            $message->save();
        }

        return response()->json(['success' => true]);
    }

    public function getUnreadCount($userId)
    {
        $count = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
    public function getallmessage($userId)
    {
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender:id,nom,prenom', 'receiver:id,nom,prenom'])
            ->get();

        return $messages;
    }
}
