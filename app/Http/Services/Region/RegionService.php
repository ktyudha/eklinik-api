<?php

namespace App\Http\Services\Region;

use Illuminate\Http\Request;
use App\Models\Region\Village;
use App\Enums\Region\RegionEnum;
use App\Models\Region\SubDistrict;
use App\Http\Resources\Region\CityResource;
use App\Http\Resources\Region\VillageResource;
use App\Http\Resources\Region\ProvinceResource;
use App\Http\Repositories\Region\CityRepository;
use App\Http\Resources\Region\SubDistrictResource;
use App\Http\Repositories\Region\VillageRepository;
use App\Http\Repositories\Region\ProvinceRepository;
use App\Http\Repositories\Region\SubDistrictRepository;

class RegionService
{
    public function __construct(
        protected VillageRepository $villageRepository,
        protected SubDistrictRepository $subDistrictRepository,
        protected CityRepository $cityRepository,
        protected ProvinceRepository $provinceRepository,
    ) {}

    public function index(Request $request)
    {
        $regions = $this->villageRepository->filterByName($request, ['subDistrict']);
        return response()->json([
            'count' => count($regions),
            'regions' => VillageResource::collection($regions)
        ]);
        // $filters = $request->only(['name']);
        // switch ($region) {
        //     case RegionEnum::VILLAGE:
        //         break;
        //     case RegionEnum::SUB_DISTRICT:
        //         return SubDistrictResource::collection($this->subDistrictRepository->filterByName($request));
        //         break;
        //     case RegionEnum::CITY:
        //         return CityResource::collection($this->cityRepository->filterByName($request));
        //         break;
        //     case RegionEnum::PROVINCE:
        //         return ProvinceResource::collection($this->provinceRepository->filterByName($request));
        //         break;
        //     default:
        //         return VillageResource::collection($this->subDistrictRepository->filterByName($request));
        //         break;

    }
}
