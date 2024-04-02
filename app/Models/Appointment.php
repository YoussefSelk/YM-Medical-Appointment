<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'reason',
        'status',
        'appointment_date',
        'doctor_comment',
        'status',
        'patient_id',
        'doctor_id',
        'schedule_id',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
