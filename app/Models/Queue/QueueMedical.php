<?php

namespace App\Models\Queue;

use App\Traits\Uuid;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QueueMedical extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'patient_id',
        'appointment_date',
        'description',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
