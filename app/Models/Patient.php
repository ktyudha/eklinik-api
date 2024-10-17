<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Region\City;
use App\Models\Region\Province;
use App\Models\Region\SubDistrict;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;


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

    protected $hidden = [
        'remember_token',
        'password',
        'encrypted_password',
        'created_at',
        'updated_at',
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
    }

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
