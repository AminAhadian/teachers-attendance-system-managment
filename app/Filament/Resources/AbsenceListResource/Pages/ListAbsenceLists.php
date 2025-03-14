<?php

namespace App\Filament\Resources\AbsenceListResource\Pages;

use App\Filament\Resources\AbsenceListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsenceLists extends ListRecords
{
    protected static string $resource = AbsenceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
