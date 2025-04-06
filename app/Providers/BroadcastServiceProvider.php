<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]); // Ensure only authenticated users access

        require base_path('routes/channels.php'); // Load channel routes
    }
}
