<?php

namespace App\Filament\Resources\AcademicFieldResource\Pages;

use App\Filament\Resources\AcademicFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicFields extends ListRecords
{
    protected static string $resource = AcademicFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
