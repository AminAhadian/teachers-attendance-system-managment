<?php

namespace App\Filament\Resources\AcademicFieldResource\Pages;

use App\Filament\Resources\AcademicFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicField extends EditRecord
{
    protected static string $resource = AcademicFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
