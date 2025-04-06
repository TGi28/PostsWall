<?php

namespace App\Http\Controllers;

use App\Events\UserOnlineStatusChanged;
use App\Http\Middleware\UpdateLastActivity;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index() {
        $posts = Post::with('user','tags')->get();
        return view('auth.index', ['posts' => $posts]);
    }

    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => ['required', Password::defaults()]
        ]);
        if(Auth::attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            return back()->with('status', 'Invalid Credentials');
        }
    }

    public function destroy() {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    public function settings() {
        return view('auth.settings');
    }

    public function update(Request $request) {
        $request->validate([
            'name' =>'required|100|string',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
        ]);
        
        $request->user()->update([
            'name'=> $request->name,
            'email'=> $request->email,
        ]);
        return back();
    }
}
