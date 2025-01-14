<?php

declare(strict_types=1);

namespace App\Enums\Region;

use BenSampo\Enum\Enum;

final class RegionEnum extends Enum
{
    const PROVINCE = 'provinces';
    const CITY = 'cities';
    const SUB_DISTRICT = 'sub_districts';
    const VILLAGE = 'villages';
}
