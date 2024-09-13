<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use Uuid;


    public $table = 'medicals';
    protected $fillable = [
        'patient_id',
        'classification_id',
        'checkup_date',
        'diagnosis',
        'complaints',
        'illness_duration_years',
        'illness_duration_months',
        'illness_duration_days',
        'medical_history',
        'drug_allergies',
        'food_allergies',
        'other_allergies',
        'sistole',
        'diastole',
        'height',
        'weight',
        'pulse',
        'temperature',
        'pregnancy',
        'heart',
        'other_checkup',
        'treatment',
        'recipe',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
}
