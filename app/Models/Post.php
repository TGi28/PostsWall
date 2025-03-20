<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "user_id",
        'views',
        'slug',
        'poster',
        'preview'
    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y');
    }

    public function getRouteKeyName() {
        return 'slug';
    }
    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
