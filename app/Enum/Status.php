<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel
{
    case Scheduled = 'Scheduled';
    case EnterOnly = 'Enter_Only';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';
    case Postponed = 'Postponed';
    case Absent = 'Absent';
    case RequiresHeadManagerReview = 'Requires_Head_Manager_Review';
    case Approved = 'Approved';
    case PendingHeadManagerReview = 'Pending_Head_Manager_Review';
    case Reviewed = 'Reviewed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Scheduled => __('Scheduled'),
            self::EnterOnly => __('Enter Only'),
            self::Completed => __('Completed'),
            self::Cancelled => __('Cancelled'),
            self::Postponed => __('Postponed'),
            self::Absent => __('Absent'),
            self::RequiresHeadManagerReview => __('Requires Head Manager Review'),
            self::Approved => __('Approved'),
            self::PendingHeadManagerReview => __('Pending Head Manager Review'),
            self::Reviewed => __('Reviewed'),
        };
    }
}
