<?php

namespace App\Http\Services\Region;

use Illuminate\Http\Request;
use App\Models\Region\Village;
use App\Http\Resources\Region\VillageResource;
use App\Http\Repositories\Region\VillageRepository;
use App\Http\Requests\Pagination\PaginationRequest;

class VillageService
{
    public function __construct(
        protected VillageRepository $villageRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        $filters = $request->only(['name']);

        $model = new Village();

        return customPaginate(
            $model,
            [
                'property_name' => 'villages',
                'resource' => VillageResource::class,
                'sort_by' => 'latest',
                'sort_by_property' => 'id',
                // 'relations' => ['subDistrict'],
            ],
            $request->page_limit ?? 10,
            $filters
        );
    }
}
