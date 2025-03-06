<?php

namespace App\Filament\Resources\DegreeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DegreeResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms\Components\Actions\Action;

class ListDegrees extends ListRecords
{
    protected static string $resource = DegreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
                ->label(__('Import'))
                ->color("primary")
                ->validateUsing([
                    'name' => 'required',
                ])->sampleExcel(
                    sampleData: [
                        ["name" => "فوق لیسانس"],
                        ["name" => "لیسانس"],
                        ["name" => "دکتری تخصصی"],
                    ],
                    fileName: 'Degree.xlsx',
                    sampleButtonLabel: __('Download Sample'),
                    customiseActionUsing: fn(Action $action) => $action->color('primary')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->requiresConfirmation(),
                ),
        ];
    }
}
