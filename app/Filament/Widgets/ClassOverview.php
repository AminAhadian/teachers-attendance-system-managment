<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Teacher;
use App\Models\ClassSchedule;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ClassOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Classes'), ClassSchedule::all()->count()),
            Stat::make(__('Total Teachers'), Teacher::all()->count()),
            Stat::make(__('Total Users'), User::all()->count()),
            Stat::make(__('Total Attendance Managers'), User::role('attendanceManager')->count()),
        ];
    }
}
