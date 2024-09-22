<?php

namespace App\Models\Menu;

use App\Traits\Uuid;
use App\Models\Classification;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Uuid;

    public $table = 'menus';
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'classification_menu', 'menu_id', 'classification_id');
    }
}
