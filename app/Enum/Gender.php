<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;


enum Gender: string implements HasLabel
{
    case Male = 'Male';
    case Female = 'Female';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Male => __('Male'),
            self::Female => __('Female'),
        };
    }
}
