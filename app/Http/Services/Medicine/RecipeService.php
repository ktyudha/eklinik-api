<?php

namespace App\Http\Services\Medicine;

use App\Http\Repositories\Medicine\RecipeRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Medicine\RecipeResource;
use Illuminate\Http\Request;
use App\Models\Medicine\Recipe;

class RecipeService
{
    public function __construct(
        protected RecipeRepository $recipeRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        return customPaginate(
            new Recipe(),
            [
                'property_name' => 'recipes',
                'resource' => RecipeResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                // 'relations' => ['patient', 'medical'],
            ],
            $request->limit ?? 10
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|string|exists:patients,id',
            'medical_id' => 'required|string|exists:medicals,id',
            'description' => 'nullable|string',
        ]);
        return $this->recipeRepository->createRecipeWithMedicine($validatedData);
    }

    public function show($id)
    {
        return $this->recipeRepository->findById($id);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|string|exists:patients,id',
            'medical_id' => 'required|string|exists:medicals,id',
            'description' => 'nullable|string',
        ]);
        return $this->recipeRepository->updateRecipeWithMedicine($id, $validatedData);
    }

    public function destroy($id)
    {
        $this->recipeRepository->delete($id);
    }
}
