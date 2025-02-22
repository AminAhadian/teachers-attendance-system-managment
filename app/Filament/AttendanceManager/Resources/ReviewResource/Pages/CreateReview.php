<?php

namespace App\Filament\AttendanceManager\Resources\ReviewResource\Pages;

use App\Enum\Status;
use App\Filament\AttendanceManager\Resources\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReview extends CreateRecord
{
    protected static string $resource = ReviewResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['attendance_manager_id'] = auth()->id();
        $data['status'] = Status::PendingHeadManagerReview->value;

        return $data;
    }
}
