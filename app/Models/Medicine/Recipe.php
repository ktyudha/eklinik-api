<?php

namespace App\Models\Medicine;

use App\Traits\Uuid;
use App\Models\Patient;
use App\Models\Medical;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use Uuid;

    public $table = 'recipes';
    protected $fillable = [
        'patient_id',
        'medical_id',
        'status',
        'description',
        'expired_date',
        'amount',
    ];


    public function syncMedicines(array $medicineIds)
    {
        $this->medicines()->sync($medicineIds);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medical()
    {
        return $this->belongsTo(Medical::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'recipe_medicine', 'recipe_id', 'medicine_id');
    }
}
