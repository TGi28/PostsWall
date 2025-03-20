<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;
use Carbon\Carbon;

class UpdateLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Update or create session record
            Session::updateOrCreate(
                ['user_id' => Auth::id()],
                ['last_activity' => Carbon::now()->timestamp]
            );
        }
        
        return $next($request);
    }
}