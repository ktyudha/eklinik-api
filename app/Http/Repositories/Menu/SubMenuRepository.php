<?php

namespace App\Http\Repositories\Menu;

use App\Http\Repositories\BaseRepository;
use App\Models\SubMenu;

class SubMenuRepository extends BaseRepository
{
    public function __construct(protected SubMenu $subMenu)
    {
        parent::__construct($subMenu);
    }
}
