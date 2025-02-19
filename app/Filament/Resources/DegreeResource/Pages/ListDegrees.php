<?php

namespace App\Filament\Resources\DegreeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DegreeResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ListDegrees extends ListRecords
{
    protected static string $resource = DegreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
                ->color("primary")
                ->validateUsing([
                    'name' => 'required',
                ]),
        ];
    }
}
