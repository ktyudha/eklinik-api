<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Menu\Menu;
use App\Models\Menu\SubMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Classification extends Model
{
    use Uuid;

    public $table = 'classifications';
    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',

    ];


    public function scopeFilters(Builder $query, array $filters)
    {
        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
    }


    public function syncMenus(array $menuIds)
    {
        $this->menus()->sync($menuIds);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'classification_menu', 'classification_id', 'menu_id');
    }

    public function submenus()
    {
        return $this->hasManyThrough(Submenu::class, Menu::class, 'classification_menu', 'menu_id', 'id', 'id');
    }
}
