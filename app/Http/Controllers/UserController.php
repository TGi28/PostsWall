<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('users.index', ['users'=>User::latest()->paginate(32)], );
    }

    public function show(User $user) {
        return view('users.show', ['user' => $user]);
    }
}
