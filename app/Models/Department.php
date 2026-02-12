<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    CONST ADMIN_DEPARTMENT = 1;
    CONST HR_DEPARTMENT = 2;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
