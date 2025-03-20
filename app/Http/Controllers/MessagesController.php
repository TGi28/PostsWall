<?php

namespace App\Http\Controllers;

use Debugbar;
use Illuminate\Http\Request;
class MessagesController extends Controller
{
    public function index()
{
    return view('messages.index');
}

}
