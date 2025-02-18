<?php

namespace App\Enum;

use ArchTech\Enums\InvokableCases;

enum Gender
{
    use InvokableCases;

    case MALE;
    case FEMALE;
}
