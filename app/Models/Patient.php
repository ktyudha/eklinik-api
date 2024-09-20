<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Region\City;
use App\Models\Region\Country;
use App\Models\Region\Province;
use App\Models\Region\SubDistrict;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use Uuid;


    public $table = 'patients';
    protected $fillable = [
        'no_medical_record',
        'name',
        'date_of_birth',
        'gender',
        'nik',
        'education',
        'job',
        'country_id',
        'province_id',
        'city_id',
        'sub_district_id',
        'address',
    ];
    protected $casts = [
        'date_of_birth' => 'date',
    ];


    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function medicals()
    {
        return $this->hasMany(Medical::class);
    }
}
