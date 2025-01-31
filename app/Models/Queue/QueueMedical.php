<?php

namespace App\Models\Queue;

use App\Traits\Uuid;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class QueueMedical extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'patient_id',
        'queue_date',
        'queue_number',
        'description',
        'status'
    ];

    protected $casts = [
        'queue_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scopeIsAwaiting(Builder $query, $patientId = null)
    {
        $query->whereDate('created_at', Carbon::today())
            ->where('status', 'waiting');

        if ($patientId !== null) {
            $query->where('patient_id', $patientId);
        }

        $query->orderBy('created_at', 'asc');

        return $query;
    }
}
