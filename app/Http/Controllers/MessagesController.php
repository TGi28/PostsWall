<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function index(Chat $chat, User $user)
    {
        $chats = auth()->user()->chat;
        $authUser = auth()->user();
        $chat = Chat::whereHas('participants', function ($query) use ($authUser) {
            $query->where('user_id', $authUser->id);
        })->whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();
        return view('messages.index', compact('chats', 'user','chat'));
    }
}
