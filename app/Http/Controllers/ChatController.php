<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class ChatController extends Controller
{
    private $pusher;

    public function __construct()
    {
        // Initialize Pusher
        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true
            ]
        );
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('pages.admin.chat.index', compact('users'))->with(['title' => 'Chat']);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        // Ambil pesan dari database
        $messages = DB::table('ch_messages')
            ->where(function ($query) use ($id) {
                $query->where('from_id', auth()->id())
                    ->where('to_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('from_id', $id)
                    ->where('to_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.admin.chat.show', compact('user', 'messages'))->with(['title' => 'Chat']);
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string'
            ]);

            $messageData = [
                'from_id' => auth()->id(),
                'to_id' => $request->receiver_id,
                'body' => $request->message,
                'attachment' => null
            ];

            $message = ChatifyMessenger::newMessage($messageData);

            if ($message) {
                // Trigger Pusher event
                $pusher = new Pusher(
                    config('broadcasting.connections.pusher.key'),
                    config('broadcasting.connections.pusher.secret'),
                    config('broadcasting.connections.pusher.app_id'),
                    [
                        'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                        'useTLS' => true
                    ]
                );

                $pusher->trigger('chat-channel', 'new-message', [
                    'message' => $message,
                    'from_id' => auth()->id(),
                    'to_id' => $request->receiver_id,
                    'time' => now()->format('H:i')
                ]);

                return response()->json([
                    'status' => 'Message Sent',
                    'message' => $message
                ], 200);
            }

            return response()->json(['error' => 'Failed to send message'], 500);
        } catch (\Exception $e) {
            Log::error("Error sending message: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to send message',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchMessages($id)
    {
        try {
            $messages = ChatifyMessenger::fetchMessagesQuery(auth()->id(), $id)->get();
            return response()->json($messages, 200);
        } catch (\Exception $e) {
            Log::error("Error fetching messages: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch messages'], 500);
        }
    }
}
