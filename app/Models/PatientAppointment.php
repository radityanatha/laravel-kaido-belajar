<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientAppointment extends Model
{
    //
    use HasFactory;
    // add fillable
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date_of_appointment',
        'note',
        'prescription',
        'status',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    //add relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id')->whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        });
    }
}
