<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'details',
        'cv',
        'status',
        'registration_token',
        'token_expiry',
    ];

    protected $casts = [
        'token_expiry' => 'datetime',
    ];
}
