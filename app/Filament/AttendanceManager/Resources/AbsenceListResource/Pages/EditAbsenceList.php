<?php

namespace App\Filament\AttendanceManager\Resources\AbsenceListResource\Pages;

use App\Filament\AttendanceManager\Resources\AbsenceListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsenceList extends EditRecord
{
    protected static string $resource = AbsenceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
