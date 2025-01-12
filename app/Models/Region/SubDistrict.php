<?php

namespace App\Models\Region;

use App\Models\Region\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDistrict extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id',
        'name',
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'sub_district_id', 'id');
    }

    // public function province()
    // {
    //     return $this->hasOneThrough(
    //         Province::class,
    //         City::class,
    //         'id',            // Foreign key di City (relasi ke SubDistrict)
    //         'id',            // Foreign key di Province (relasi ke City)
    //         'city_id',       // Local key di SubDistrict (relasi ke City)
    //         'province_id'
    //     );
    // }
}
