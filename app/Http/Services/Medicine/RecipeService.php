<?php

namespace App\Http\Services\Medicine;

use App\Models\Medicine\Recipe;
use App\Http\Requests\Medicine\RecipeCreateRequest;
use App\Http\Requests\Medicine\RecipeUpdateRequest;
use App\Http\Resources\Medicine\RecipeResource;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Medicine\RecipeRepository;

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

    public function store(RecipeCreateRequest $request)
    {
        return $this->recipeRepository->createRecipeWithMedicine($request->validated());
    }

    public function show($id)
    {
        return $this->recipeRepository->findById($id);
    }

    public function update($id, RecipeUpdateRequest $request)
    {
        return $this->recipeRepository->updateRecipeWithMedicine($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->recipeRepository->delete($id);
    }
}
