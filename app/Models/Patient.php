<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'cin',
        'birth_date',
        'user_id',
    ];
    public  function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
