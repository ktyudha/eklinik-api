<?php

namespace App\Http\Controllers\Api\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Menu\SubMenuResource;
use App\Http\Requests\Menu\SubMenuCreateRequest;
use App\Http\Requests\Menu\SubMenuUpdateRequest;
use App\Http\Services\Menu\SubMenuService;

class SubMenuController extends Controller
{
    public function __construct(protected SubMenuService $subMenuService) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'sub_menu' => SubMenuResource::collection($this->subMenuService->index())
        ]);
    }

    public function store(SubMenuCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'sub_menu' => new SubMenuResource($this->subMenuService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'sub_menu' => new SubMenuResource($this->subMenuService->show($id))
        ]);
    }

    public function update(SubMenuUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'sub_menu' => new SubMenuResource($this->subMenuService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->subMenuService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
