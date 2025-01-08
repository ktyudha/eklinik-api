<?php

namespace App\Models\Menu;

use App\Traits\Uuid;
use App\Models\Classification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Menu extends Model
{
    use Uuid;

    public $table = 'menus';
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
    }

    public function submenus()
    {
        return $this->hasMany(SubMenu::class);
    }

    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'classification_menu', 'menu_id', 'classification_id');
    }
}
