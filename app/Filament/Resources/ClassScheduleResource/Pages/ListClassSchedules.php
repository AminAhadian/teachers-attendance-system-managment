<?php

namespace App\Filament\Resources\ClassScheduleResource\Pages;

use Filament\Actions;
use App\Imports\ClassScheduleImport;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ClassScheduleResource;

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
                    'calendar' => ['required'],
                    'ostad_personnel_code' => ['required', 'numeric', 'exists:teachers,personnel_code'],
                    'name' => ['required', 'string'],
                    'code' => ['required', 'numeric'],
                    'presentation_code' => ['required', 'numeric'],
                    'educational_group_code' => ['required', 'numeric', 'exists:educational_groups,code'],
                    'term' => ['required', 'numeric'],
                ])
                ->use(ClassScheduleImport::class)
                ->sampleExcel(
                    sampleData: [
                        [
                            "term" => "4032",
                            "ostad_personnel_code" => "4957101917",
                            "name" => "اندیشه های امامین انقلاب اسلامی و وصایای حضرت امام خمینی(ره)",
                            "code" => "99073",
                            "presentation_code" => "1069",
                            "educational_group_code" => "5112799",
                            "location" => "127 - سبزوار",
                            "calendar" => "چهارشنبه 14:00 تا 16:00 ؛"
                        ],
                        [
                            "term" => "4032",
                            "ostad_personnel_code" => "4956287208",
                            "name" => "انس با قرآن کریم",
                            "code" => "99083",
                            "presentation_code" => "1078",
                            "educational_group_code" => "5112799",
                            "location" => "127 - سبزوار",
                            "calendar" => "چهارشنبه 12:00 تا 14:00 ؛"
                        ],
                        [
                            "term" => "4032",
                            "ostad_personnel_code" => "8527150053",
                            "name" => "انس با قرآن کریم",
                            "code" => "99083",
                            "presentation_code" => "1080",
                            "educational_group_code" => "5112799",
                            "location" => "127 - سبزوار",
                            "calendar" => "چهارشنبه 14:00 تا 16:00 ؛"
                        ],
                    ],
                    fileName: 'Classes.xlsx',
                    sampleButtonLabel: __('Download Sample'),
                    customiseActionUsing: fn(Action $action) => $action->color('primary')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->requiresConfirmation(),
                ),
        ];
    }
}
