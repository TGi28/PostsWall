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

    /**
     * Get the other participant in the chat (not the current user)
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getOtherParticipantAttribute()
    {
        return $this->participants->where('id', '!=', auth()->id())->first();
    }
}
