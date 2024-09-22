<?php

namespace App\Http\Repositories\Medicine;

use App\Http\Repositories\BaseRepository;
use App\Models\Medicine\Recipe;

class RecipeRepository extends BaseRepository
{
    public function __construct(protected Recipe $recipe)
    {
        parent::__construct($recipe);
    }

    public function createRecipeWithMedicine($data)
    {

        $recipe = $this->model::create($data);

        if (isset($data['medicine'])) {
            $recipe->syncMenus($data['medicine']);
        }

        return $recipe;
    }

    public function updateRecipeWithMedicine($id, $data)
    {

        $recipe = $this->model::findOrFail($id);
        $recipe->update($data);

        if (isset($data['medicine'])) {
            $recipe->syncMenus($data['medicine']);
        }

        return $recipe;
    }
}
