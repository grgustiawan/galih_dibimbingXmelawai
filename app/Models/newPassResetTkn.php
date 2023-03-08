<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class newPassResetTkn extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'email'
    ];

    protected $cast = [
        'created_at' => 'datetime'
    ];
}
