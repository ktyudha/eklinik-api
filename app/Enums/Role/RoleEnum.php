<?php

namespace App\Enums\Role;

use BenSampo\Enum\Enum;

final class RoleEnum extends Enum
{
    const ADMIN = 'admin';
    const STUDENT = 'student';
    const SCHOOL = 'school';
    const AGENCY = 'agency';
    const SUB_AGENCY = 'sub-agency';
}
