<?php

namespace App\Filament\Resources\EducationalGroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms\Components\Actions\Action;
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
                ])->sampleExcel(
                    sampleData: [
                        [
                            "name" => "گروه آموزشي مديريت",
                            "code" => "5112711",
                        ],
                        [
                            "name" => "گروه آموزشي حسابداري",
                            "code" => "5112712",
                        ]
                    ],
                    fileName: 'EducationalGroup.xlsx',
                    sampleButtonLabel: __('Download Sample'),
                    customiseActionUsing: fn(Action $action) => $action->color('primary')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->requiresConfirmation(),
                ),
        ];
    }
}
