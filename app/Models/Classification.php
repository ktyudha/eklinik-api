<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

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

    public function syncMenus(array $menuIds)
    {
        $this->menus()->sync($menuIds);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'classification_menu', 'classification_id', 'menu_id');
    }
}
