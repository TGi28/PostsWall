<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $query = User::query();
        $query->with('posts')->withCount('posts');
        $query->orderBy('posts_count', 'desc');
        $users = $query->paginate(33);
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user) {
        return view('users.show', ['user' => $user]);
    }
}
