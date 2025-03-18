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

    public function updateClassificationWithMenu($classificationId, $data)
    {

        $classification = $this->model::findOrFail($classificationId);

        // Update the classification's attributes
        $classification->update($data);

        // Sync the menus if they are provided in the data
        if (isset($data['menu'])) {
            $classification->syncMenus($data['menu']);
        }
        return $classification;
    }
}
