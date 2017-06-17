<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    // fillable table
    protected $fillable = [
    'email',
    'name',
    'password'
    ];
}
