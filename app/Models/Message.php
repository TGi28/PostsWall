<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = ['user_id', 'chat_id', 'message'];

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
}
