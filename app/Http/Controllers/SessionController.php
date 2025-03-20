<?php

namespace App\Http\Controllers;

use App\Events\UserOnlineStatusChanged;
use App\Http\Middleware\UpdateLastActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index() {
        return view('auth.index', ['posts' => auth()->user()->posts]);
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
            event(new UserOnlineStatusChanged(auth()->user(), 'online'));
            return redirect()->intended('/');
        } else {
            return back()->with('status', 'Invalid Credentials');
        }
    }

    public function destroy() {
        event(new UserOnlineStatusChanged(auth()->user(), 'offline'));
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
            'first_name' =>'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
        ]);
        
        $request->user()->update([
            'name'=> $request->first_name . ' ' . $request->last_name,
            'email'=> $request->email,
        ]);
        return back();
    }
}
