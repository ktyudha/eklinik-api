<?php

namespace App\Models\Menu;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SubMenu extends Model
{
    use Uuid;

    public $table = 'sub_menus';
    protected $fillable = [
        'menu_id',
        'name',
        'type',
        'is_active',
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        $query
            ->when(isset($filters['name']) && $filters['name'] !== null, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
