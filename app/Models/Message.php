<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = ['user_id', 'chat_id', 'message', 'is_edited','replied_to','file'];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('H:i');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function chat() {
        return $this->belongsTo(Chat::class);
    }

    public function repliedMessage() {
        return $this->belongsTo(Message::class, 'replied_to');
    }
}
