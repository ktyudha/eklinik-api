<?php

namespace App\Http\Repositories\Medicine;

use App\Http\Repositories\BaseRepository;
use App\Models\Medicine\MedicineCategory;

class MedicineCategoryRepository extends BaseRepository
{
    public function __construct(protected MedicineCategory $medicineCategory)
    {
        parent::__construct($medicineCategory);
    }
}
