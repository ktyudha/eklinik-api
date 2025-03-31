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

    public function scopeFilters(Builder $query, array $filters): void
    {
        $query
            // ->when(isset($filters['is_new_order']) && $filters['is_new_order'] !== null, function ($query) use ($filters) {
            //     $query->when($filters['is_new_order'] == true, function ($query) {
            //         $query->whereDate('date', '>=', now()->subDays(3)->toDateString())
            //             ->whereDate('date', '<=', now()->toDateString());
            //     });
            // })
            ->when(isset($filters['queue_date']) && $filters['queue_date'] !== null, function ($query) use ($filters) {
                $query->whereDate('queue_date', '==', $filters['queue_date']);
            })
            ->when(isset($filters['status']) && $filters['status'] !== null, function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when(isset($filters['complaint']) && $filters['complaint'] !== null, function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['complaint'] . '%');
            })
            ->when(isset($filters['patient_name']) && $filters['patient_name'] !== null, function ($query) use ($filters) {
                $query->whereHas('patient', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['patient_name'] . '%');
                });
            });
    }
}
