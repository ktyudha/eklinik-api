<?php

namespace App\Models\Medicine;

use App\Models\Medicine\Recipe;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use Uuid;

    protected $fillable = [
        'medicine_category_id',
        'name',
        'description',
        'expired_date',
        'unit',
        'stock',
        'price',
    ];

    protected $casts = [
        'expired_date' => 'datetime',
    ];

    public function medicineCategory()
    {
        return $this->belongsTo(MedicineCategory::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_medicine', 'medicine_id', 'recipe_id');
    }
}
