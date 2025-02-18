<?php

namespace App\Filament\Resources\TermScheduleResource\Pages;

use App\Filament\Resources\TermScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermSchedule extends EditRecord
{
    protected static string $resource = TermScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
