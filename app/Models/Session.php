<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';  // Laravel's default session table name
    protected $primaryKey = 'id';
    public $timestamps = false;
}

