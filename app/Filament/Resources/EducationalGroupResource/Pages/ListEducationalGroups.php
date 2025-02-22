<?php

namespace App\Filament\Resources\EducationalGroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\EducationalGroupResource;

class ListEducationalGroups extends ListRecords
{
    protected static string $resource = EducationalGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
            ->label(__('Import'))
                ->color("primary")
                ->validateUsing([
                    'name' => 'required',
                    'code' => 'required',
                ]),
        ];
    }
}
