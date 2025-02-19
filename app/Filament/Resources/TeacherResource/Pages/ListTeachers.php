<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TeacherResource;
use App\Imports\TeacherImport;
use EightyNine\ExcelImport\ExcelImportAction;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
                ->color("primary")
                ->use(TeacherImport::class)
                ->validateUsing([
                    'name' => 'required',
                    'national_code' => 'required|numeric',
                    'personnel_code' => 'required|numeric',
                    'gender' => 'required',
                    'degree' => 'nullable',
                    'academic_field' => 'nullable',
                ]),
        ];
    }
}
