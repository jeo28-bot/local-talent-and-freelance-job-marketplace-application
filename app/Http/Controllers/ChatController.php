<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\BlockedUser;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show($name)
{
    $receiver = User::where('name', $name)->firstOrFail();
    $user = auth()->user();

    // ✅ Mark all messages from the receiver as seen when the employee opens the chat
    Message::where('sender_id', $receiver->id)
        ->where('receiver_id', $user->id)
        ->where('seen', false)
        ->update(['seen' => true]);

    // messages between the two
    $messages = Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    // recent chats
    $recentChats = Message::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })
        ->latest('created_at')
        ->get()
        ->groupBy(function ($message) use ($user) {
            return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
        });

    $chatUserIds = array_keys($recentChats->toArray());

    $chatUsers = User::whereIn('id', $chatUserIds)
        ->get()
        ->sortBy(function ($user) use ($chatUserIds) {
            return array_search($user->id, $chatUserIds);
        });

    // ✅ NEW: check if this chat should show the "blocked" div
    $isBlocked = \App\Models\BlockedUser::where(function ($query) use ($user, $receiver) {
            $query->where('user_id', $user->id)
                  ->where('blocked_user_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($user, $receiver) {
            $query->where('user_id', $receiver->id)
                  ->where('blocked_user_id', $user->id);
        })
        ->exists();

    $rolePrefix = request()->is('employee/*') ? 'employee' : 'client';
    $view = $rolePrefix === 'employee' ? 'employee.chat' : 'client.chat';

    return view($view, compact('receiver', 'messages', 'chatUsers', 'user', 'rolePrefix', 'isBlocked'));
}







    public function sendMessage(Request $request, $receiverName)
    {
        $receiver = User::where('name', $receiverName)->firstOrFail();

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'content' => $request->content,
        ]);

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'content' => $message->content,
                'created_at' => $message->created_at->format('g:i a'),
                'sender_id' => $message->sender_id
            ]);
        }

        // fallback (for non-AJAX)
        $routeName = $request->route() ? $request->route()->getName() : null;
        if (is_string($routeName) && str_starts_with($routeName, 'employee.')) {
            return redirect()->route('employee.chat', ['name' => $receiver->name]);
        }

        return redirect()->route('client.chat', ['name' => $receiver->name]);
    }


    public function getMessages($name)
    {
        $receiver = User::where('name', $name)->firstOrFail();
        $user = auth()->user();

        $messages = \App\Models\Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })->latest()->take(50)->get()->reverse()->values();

        return response()->json($messages);
    }

    public function fetchMessages($name)
    {
        $receiver = User::where('name', $name)->firstOrFail();
        $user = auth()->user();

        $messages = Message::where(function ($query) use ($user, $receiver) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($query) use ($user, $receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }


    public function deleteChat($name)
    {
        $user = auth()->user();
        $receiver = User::where('name', $name)->firstOrFail();

        // Delete all messages between these two
        Message::where(function($q) use ($user, $receiver) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiver->id);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $user->id);
        })->delete();

        return response()->json(['success' => true]);
    }





    public function index()
    {
        $user = auth()->user();

        // Get all chat partners
        $recentChats = Message::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->latest('created_at')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });

        // Get actual user models of those chat partners
        $chatUsers = User::whereIn('id', array_keys($recentChats->toArray()))->get();

        // ✅ include $user too
        return view('client.chat_menu', compact('chatUsers', 'user'));
    }


     // client messages fetch for auto refresh purpose
    
    public function recentMessages()
    {
        $user = auth()->user();

        // Get all unique users the client has chatted with (either sender or receiver)
        $chatUsers = \App\Models\User::whereHas('messagesSent', function ($query) use ($user) {
                $query->where('receiver_id', $user->id);
            })
            ->orWhereHas('messagesReceived', function ($query) use ($user) {
                $query->where('sender_id', $user->id);
            })
            ->get()
            ->map(function ($chatUser) use ($user) {
                $lastMessage = \App\Models\Message::where(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $chatUser->id);
                    })
                    ->orWhere(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $chatUser->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'user' => $chatUser,
                    'last_message' => $lastMessage ? $lastMessage->content : 'No messages yet',
                    'time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                ];
            });

        return view('client.messages', compact('chatUsers'));
    }

  public function fetchRecentChats()
    {
        $user = auth()->user();

        $recentChats = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id === $user->id
                    ? $message->receiver_id
                    : $message->sender_id;
            })
            ->map(function ($messages, $userId) use ($user) {
                $lastMessage = $messages->first();
                $otherUser = User::find($userId);

                // 👇 Add "You:" prefix if the authenticated user sent the last message
                $content = $lastMessage->sender_id === $user->id
                    ? 'You: ' . $lastMessage->content
                    : $lastMessage->content;

                // 👇 Check if there are any unseen messages from this chat user
                $hasUnseen = Message::where('sender_id', $userId)
                    ->where('receiver_id', $user->id)
                    ->where('seen', false)
                    ->exists();

                return [
                    'name' => $otherUser->name,
                    'profile_pic' => $otherUser->profile_pic
                        ? asset('storage/' . $otherUser->profile_pic)
                        : asset('assets/defaultUserPic.png'),
                    'latest_message' => $content,
                    'latest_sender_id' => $lastMessage->sender_id,
                    'seen' => $lastMessage->seen, // keeps the original last message seen
                    'has_unseen' => $hasUnseen,   // ✅ new flag for unseen messages
                    'time' => $lastMessage->created_at->diffForHumans(),
                ];
            })
            ->values();

        return response()->json($recentChats);
    }



   public function clientMessages(Request $request)
    {
        $user = auth()->user();

        $chatUsers = User::whereHas('messagesSent', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->orWhereHas('messagesReceived', function ($q) use ($user) {
                $q->where('sender_id', $user->id);
            })
            ->get()
            ->map(function ($chatUser) use ($user) {
                $lastMessage = Message::where(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $chatUser->id);
                    })
                    ->orWhere(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $chatUser->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'user' => $chatUser,
                    'last_message' => $lastMessage
                        ? (($lastMessage->sender_id === $user->id ? 'You: ' : '') . $lastMessage->content)
                        : 'No messages yet',
                    'time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : now()->subYears(10),
                ];
            })
            ->sortByDesc('last_message_time')
            ->values();

        // 🔹 Manual Pagination
        $perPage = 5;
        $page = $request->input('page', 1);
        $items = $chatUsers->forPage($page, $perPage);

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $chatUsers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('client.messages', [
            'chatUsers' => $paginated,
        ]);
    }





    // employee messages fetch for auto refresh purpose

    public function employeeMessages(Request $request)
    {
        $user = auth()->user();

        // Get all users the employee has chatted with
        $chatUsers = \App\Models\User::whereHas('messagesSent', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->orWhereHas('messagesReceived', function ($q) use ($user) {
                $q->where('sender_id', $user->id);
            })
            ->get()
            ->map(function ($chatUser) use ($user) {
                $lastMessage = \App\Models\Message::where(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $chatUser->id);
                    })
                    ->orWhere(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $chatUser->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'user' => $chatUser,
                    'last_message' => $lastMessage 
                        ? (($lastMessage->sender_id === $user->id ? 'You: ' : '') . $lastMessage->content)
                        : 'No messages yet',
                    'time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : now()->subYears(10), // for sorting
                ];
            })
            ->sortByDesc('last_message_time') // latest first
            ->values();

        // 🔹 Manual Pagination
        $perPage = 5;
        $page = $request->input('page', 1);
        $items = $chatUsers->forPage($page, $perPage);

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $chatUsers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('employee.messages', [
            'chatUsers' => $paginated,
        ]);
    }



   public function fetchEmployeeMessages()
    {
        $user = auth()->user();

        $chatUsers = \App\Models\User::whereHas('messagesSent', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->orWhereHas('messagesReceived', function ($q) use ($user) {
                $q->where('sender_id', $user->id);
            })
            ->get()
            ->map(function ($chatUser) use ($user) {
                $lastMessage = \App\Models\Message::where(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $chatUser->id);
                    })
                    ->orWhere(function ($query) use ($user, $chatUser) {
                        $query->where('sender_id', $chatUser->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                $hasUnseenMessage = \App\Models\Message::where('sender_id', $chatUser->id)
                    ->where('receiver_id', $user->id)
                    ->where('seen', false)
                    ->exists();

                return [
                    'name' => $chatUser->name,
                    'profile_pic' => $chatUser->profile_pic 
                        ? asset('storage/' . $chatUser->profile_pic)
                        : asset('assets/defaultUserPic.png'),
                    'latest_message' => $lastMessage 
                        ? (($lastMessage->sender_id === $user->id ? 'You: ' : '') . $lastMessage->content)
                        : 'No messages yet',
                    'time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'has_unseen' => $hasUnseenMessage,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : now()->subYears(10),
                ];
            })
            ->sortByDesc('last_message_time') // 🧠 consistent sorting
            ->values();

        return response()->json($chatUsers);
    }



    public function fetchEmployeeMessagesPaginated(Request $request)
    {
        $user = auth()->user();

        // Same logic as your original fetchEmployeeMessages
        $chatUsers = \App\Models\User::whereHas('messagesSent', fn($q) => $q->where('receiver_id', $user->id))
            ->orWhereHas('messagesReceived', fn($q) => $q->where('sender_id', $user->id))
            ->get()
            ->map(function ($chatUser) use ($user) {
                $lastMessage = \App\Models\Message::where(fn($q) => $q->where('sender_id', $user->id)
                        ->where('receiver_id', $chatUser->id))
                    ->orWhere(fn($q) => $q->where('sender_id', $chatUser->id)
                        ->where('receiver_id', $user->id))
                    ->latest()
                    ->first();

                $hasUnseenMessage = \App\Models\Message::where('sender_id', $chatUser->id)
                    ->where('receiver_id', $user->id)
                    ->where('seen', false)
                    ->exists();

                return [
                    'name' => $chatUser->name,
                    'profile_pic' => $chatUser->profile_pic 
                        ? asset('storage/' . $chatUser->profile_pic)
                        : asset('assets/defaultUserPic.png'),
                    'latest_message' => $lastMessage 
                        ? (($lastMessage->sender_id === $user->id ? 'You: ' : '') . $lastMessage->content)
                        : 'No messages yet',
                    'time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'has_unseen' => $hasUnseenMessage,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : now()->subYears(10),
                ];
            })
            ->sortByDesc('last_message_time')
            ->values();

        // Manual pagination
        $perPage = 5;
        $page = $request->input('page', 1);
        $items = $chatUsers->forPage($page, $perPage);

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $chatUsers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return response()->json($paginated);
    }

    
    public function employeeBlockedDiv($receiverId)
    {
        $employee = auth()->user();

        return \App\Models\BlockedUser::where(function ($query) use ($employee, $receiverId) {
                // Employee blocked the receiver
                $query->where('user_id', $employee->id)
                    ->where('blocked_user_id', $receiverId);
            })
            ->orWhere(function ($query) use ($employee, $receiverId) {
                // Receiver blocked the employee
                $query->where('user_id', $receiverId)
                    ->where('blocked_user_id', $employee->id);
            })
            ->exists();
    }



}
