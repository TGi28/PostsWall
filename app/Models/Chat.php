<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function participants() {
        return $this->belongsToMany(User::class, 'chat_participants');
    }
}
