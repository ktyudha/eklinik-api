<?php

namespace App\Http\Repositories\Menu;

use App\Http\Repositories\BaseRepository;
use App\Models\Menu\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct(protected Menu $menu)
    {
        parent::__construct($menu);
    }

    public function fetchMenuWithSubMenu(string $menuId)
    {
        return $this->model->where('id', $menuId)
            ->with('submenus')
            ->first();
    }
}
