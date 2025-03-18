<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Chat;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('chat_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Chat::class, 'chat_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
        Schema::dropIfExists('chat_participants');
    }
};
