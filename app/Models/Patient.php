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
        'medical_record_number',
        'name',
        'username',
        'password',
        'encrypted_password',
        'nik',
        'email',
        'phone_number',
        'religion',
        'gender',
        'birth_place',
        'birth_date',
        'marital_status',
        'education',
        'job',
        'province_id',
        'city_id',
        'sub_district_id',
        'village',
    ];
    protected $casts = [
        'birth_date' => 'date',
    ];


    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function medicals()
    {
        return $this->hasMany(Medical::class);
    }
}
