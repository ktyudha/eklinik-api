<?php

namespace App\Http\Controllers\Api\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Services\Medicine\RecipeService;
use App\Http\Resources\Medicine\RecipeResource;

class RecipeController extends Controller
{
    public function __construct(protected RecipeService $recipeService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->recipeService->index($request);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'recipe' => new RecipeResource($this->recipeService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'recipe' => new RecipeResource($this->recipeService->show($id))
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'recipe' => new RecipeResource($this->recipeService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->recipeService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
