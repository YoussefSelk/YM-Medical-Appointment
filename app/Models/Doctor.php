<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    public function  user()
    {
        return $this->belongsTo(User::class);
    }
    public function  specialty()
    {
        return $this->hasOne(Speciality::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function Appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
