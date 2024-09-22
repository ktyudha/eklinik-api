<?php

namespace App\Models\Menu;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

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

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
