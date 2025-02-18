<?php

namespace App\Filament\Resources\TermScheduleResource\Pages;

use App\Filament\Resources\TermScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermSchedules extends ListRecords
{
    protected static string $resource = TermScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
