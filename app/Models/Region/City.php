<?php

namespace App\Models\Region;

use App\Models\School\School;
use App\Models\Region\Province;
use App\Models\Region\SubDistrict;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'province_id',
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
    }

    // public function scopeFilters(Builder $query, array $filters)
    // {
    //     $query
    //         ->when(isset($filters['province_id']) && $filters['province_id'] !== null, function ($query) use ($filters) {
    //             return $query->where('province_id', $filters['province_id']);
    //         })
    //         ->when(isset($filters['city_id']) && $filters['city_id'] !== null, function ($query) use ($filters) {
    //             return $query->where('id', $filters['city_id']);
    //         })
    //         ->when(isset($filters['education_status']) || isset($filters['education_type']), function ($query) use ($filters) {
    //             return $query->with(['schools' => function ($query) use ($filters) {
    //                 if (isset($filters['education_status'])) {
    //                     $query->where('education_status', $filters['education_status']);
    //                 }
    //                 if (isset($filters['education_type'])) {
    //                     $query->where('education_type', $filters['education_type']);
    //                 }
    //             }]);
    //         });
    // }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function subDistricts()
    {
        return $this->hasMany(SubDistrict::class);
    }
    // public function schools()
    // {
    //     return $this->hasMany(School::class);
    // }
}
