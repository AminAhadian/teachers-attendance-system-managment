<?php

namespace App\Filament\Resources\AcademicFieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\AcademicFieldResource;

class ListAcademicFields extends ListRecords
{
    protected static string $resource = AcademicFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
            ->label(__('Import'))
                ->color("primary")
                ->validateUsing([
                    'name' => 'required',
                ]),
        ];
    }
}
