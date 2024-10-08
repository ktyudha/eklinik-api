<?php

namespace App\Http\Repositories\Classification;

use App\Http\Repositories\BaseRepository;
use App\Models\Classification;

class ClassificationRepository extends BaseRepository
{
    public function __construct(protected Classification $classification)
    {
        parent::__construct($classification);
    }

    public function fetchByName(string $name)
    {
        return Classification::where('name', $name)->first();
    }

    public function createClassificationWithMenu($data)
    {

        $classification = $this->model::create($data);

        if (isset($data['menu'])) {
            $classification->syncMenus($data['menu']);
        }

        return $classification;
    }
}
