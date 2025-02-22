<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Enum\Status;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ReviewResource;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['status'] = Status::Reviewed->value;

        return $data;
    }
}
