<?php

namespace App\Filament\Resources\ClassScheduleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\ClassScheduleResource;
use App\Imports\ClassScheduleImport;

class ListClassSchedules extends ListRecords
{
    protected static string $resource = ClassScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
            ->label(__('Import'))
                ->color("primary")
                ->validateUsing([
                    'name' => 'required',
                ])
                ->use(ClassScheduleImport::class),
        ];
    }
}
