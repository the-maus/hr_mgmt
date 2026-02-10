<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
