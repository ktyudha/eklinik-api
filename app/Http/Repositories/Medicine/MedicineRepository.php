<?php

namespace App\Http\Repositories\Medicine;

use App\Http\Repositories\BaseRepository;
use App\Models\Medicine\Medicine;

class MedicineRepository extends BaseRepository
{
    public function __construct(protected Medicine $medicine)
    {
        parent::__construct($medicine);
    }

    public function getMedicinesByIds(array $medicineIds)
    {
        return Medicine::whereIn('id', $medicineIds)->get();
    }
}
