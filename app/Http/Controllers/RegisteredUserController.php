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

    public function store() {
        request()->validate( [
            'first_name' => 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::default()]
        ]);

        $user = User::create([
            'first_name'=> request('first_name'),
            'last_name'=> request('last_name'),
            'email'=> request('email'),
            'password'=> bcrypt(request('password')),
            'slug' => Str::slug((request('first_name') .' '. request('last_name')) . ' ' . fake()->unique()->numberBetween(1, 1000)),
            'admin' => false,
        ]);

        auth()->login($user);
        return redirect('/users');
    }
}
