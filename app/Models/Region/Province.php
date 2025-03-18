<?php

namespace App\Models\Region;

use App\Models\Region\City;
use App\Models\Region\SubDistrict;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    public $table = 'provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function subDistricts()
    {
        return $this->hasManyThrough(SubDistrict::class, City::class);
    }
}
