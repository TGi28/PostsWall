<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "comment_text",
        "user_id",
        "post_id"
    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y, H:i');
    }

    public function posts() {
        return $this->belongsTo(Post::class, "post_id");
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }
}
