<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\Region\CityResource;
use App\Http\Repositories\Region\CityRepository;
use App\Http\Repositories\Region\CountryRepository;
use App\Http\Resources\Region\ProvinceResource;
use App\Http\Repositories\Region\ProvinceRepository;
use App\Http\Repositories\Region\SubDistrictRepository;
use App\Http\Resources\Region\CountryResource;
use App\Http\Resources\Region\SubDistrictResource;

class RegionController extends Controller
{
    public function __construct(
        protected ProvinceRepository $provinceRepository,
        protected CityRepository $cityRepository,
        protected SubDistrictRepository $subDistrictRepository,
        protected CountryRepository $countryRepository
    ) {}

    public function provinceIndex()
    {
        return response()->json([
            'provinces' => ProvinceResource::collection($this->provinceRepository->findAll(['cities']))
        ]);
    }

    public function cityIndex()
    {
        return response()->json([
            'cities' => CityResource::collection($this->cityRepository->findAll(['subDistricts']))
        ]);
    }

    public function subDistrictIndex()
    {
        return response()->json([
            'sub_districts' => SubDistrictResource::collection($this->subDistrictRepository->findAll())
        ]);
    }

    public function countryIndex()
    {
        return response()->json([
            'countries' => CountryResource::collection($this->countryRepository->findAll())
        ]);
    }

    public function findOneProvince($id)
    {
        $province = $this->provinceRepository->findById($id, ['cities']);

        return response()->json([
            'province' => new ProvinceResource($province),
        ]);
    }

    public function findOneCity($id)
    {
        $city = $this->cityRepository->findById($id, ['subDistricts']);

        return response()->json([
            'city' => new CityResource($city),
        ]);
    }

    public function findOneCountry($id)
    {
        $country = $this->countryRepository->findById($id);

        return response()->json([
            'country' => new CountryResource($country),
        ]);
    }
}
