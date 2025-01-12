<?php

namespace App\Models\Region;

use App\Models\Region\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;
    public $table = 'villages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sub_district_id',
        'name',
        'postal_code',
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
        // $query
        //     ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
        //         $query->where('name', 'like', '%' . $filters['name'] . '%');
        //     });

        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                // Prioritaskan province_id 35 terlebih dahulu
                $query->whereHas('subDistrict.city.province', function ($query) {
                    $query->where('id', 35);
                });

                $query
                    ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                        $query->where('name', 'like', '%' . $filters['name'] . '%');
                    });

                // $query->where(function ($query) use ($filters) {
                //     $query->where('name', 'like', '%' . $filters['name'] . '%')
                //         ->orWhereHas('subDistrict', function ($query) use ($filters) {
                //             $query->where('name', 'like', '%' . $filters['name'] . '%');
                //         });
                // });
            });
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
