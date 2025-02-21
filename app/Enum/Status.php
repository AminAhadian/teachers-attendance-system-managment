<?php

namespace App\Enum;

use ArchTech\Enums\InvokableCases;

enum Status
{
    use InvokableCases;

    case SCHEDULED;
    case ENTER_ONLY;
    case COMPLETED;
    case CANCELLED;
    case POSTPONDED;
    case ABSENT;
}
