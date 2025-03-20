<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function create() {
        return view("auth.register");
    }

    public function store(Request $request) {
        $request->validate( [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::default()]
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'admin' => false,
        ]);

        auth()->login($user);
        return redirect('/');
    }
}
