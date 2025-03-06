<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use Filament\Actions;
use App\Imports\TeacherImport;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TeacherResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms\Components\Actions\Action;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
                ->label(__('Import'))
                ->color("primary")
                ->use(TeacherImport::class)
                ->validateUsing([
                    'name' => 'required',
                    'personnel_code' => 'required|numeric',
                    'gender' => 'required',
                    'degree' => 'nullable',
                    'academic_field' => 'nullable',
                ])->sampleExcel(
                    sampleData: [
                        [
                            "name" => "کاربر تست",
                            "personnel code" => "1234567890",
                            "gender" => "زن",
                            "degree" => "فوق لیسانس",
                            "academic field" => "دامپزشکی"
                        ],
                    ],
                    fileName: 'teachers.xlsx',
                    sampleButtonLabel: __('Download Sample'),
                    customiseActionUsing: fn(Action $action) => $action->color('primary')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->requiresConfirmation(),
                ),
        ];
    }
}
