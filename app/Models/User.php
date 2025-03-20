<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function session()
{
    return $this->hasOne(Session::class, 'user_id', 'id');
}


public function isOnline()
{
    $session = $this->session;
    
    if (!$session || !$session->last_activity) {
        return false;
    }

    // Convert last_activity to a Carbon instance if it's a timestamp
    $lastActivity = is_numeric($session->last_activity)
        ? Carbon::createFromTimestamp($session->last_activity)
        : Carbon::parse($session->last_activity);

    return $lastActivity > now()->subMinutes();
}




    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function notifications() {
        return $this->hasMany(Notifications::class);
    }

    public function chat() {
        return $this->belongsToMany(Chat::class, 'chat_participants');
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
    public function getRouteKeyName() {
        return "slug";
    }

    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'slug',
        'admin',
        'avatar',
        'reactions',
        'subscriptions'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'reactions' => 'array',
        'subscriptions' => 'array' // Cast as object instead of array
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
