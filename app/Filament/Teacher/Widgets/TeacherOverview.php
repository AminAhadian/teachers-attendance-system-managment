<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\ClassSession;
use App\Models\ClassSchedule;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TeacherOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Classes'), ClassSchedule::where('teacher_id', auth()->user()->teacher->id)->count()),
            Stat::make(__('Total Completed Sessions'), ClassSession::where('teacher_id', auth()->user()->teacher->id)->whereStatus('Completed')->count()),
            Stat::make(__('Total Absent Sessions'), ClassSession::where('teacher_id', auth()->user()->teacher->id)->whereStatus(['Absent', 'Enter_Only'])->count()),
        ];
    }
}
