<?php

namespace App\Models\Medicine;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class MedicineCategory extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'description',
    ];


    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }
}
