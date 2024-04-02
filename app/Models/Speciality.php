<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function  doctors()
    {
        return $this->hasMany(Doctor::class, 'specialty_id');
    }
}
