<?php

namespace App\Filament\Resources\AcademicFieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms\Components\Actions\Action;
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
                ])->sampleExcel(
                    sampleData: [
                        ["name" => "پرستاری"],
                        ["name" => "الهیات و معارف اسلامی گرایش فقه و اصول"],
                        ["name" => "صنایع غذایی"],
                    ],
                    fileName: 'Reshte.xlsx',
                    sampleButtonLabel: __('Download Sample'),
                    customiseActionUsing: fn(Action $action) => $action->color('primary')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->requiresConfirmation(),
                ),
        ];
    }
}
