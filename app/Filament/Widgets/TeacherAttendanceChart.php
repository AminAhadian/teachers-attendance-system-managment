<?php

namespace App\Filament\Widgets;

use App\Models\ClassSession;
use App\Models\Teacher;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TeacherAttendanceChart extends ChartWidget
{
    use InteractsWithPageFilters;

    public ?string $filter = 'today';
    protected static ?string $maxHeight = 'auto';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $presenceData = $this->getTeacherPresenceData();
        $absenceData = $this->getTeacherAbsenceData();

        return [
            'datasets' => [
                [
                    'label' => __('Teachers Presence (in Hours)'),
                    'data' => $presenceData,
                    'backgroundColor' => '#dbf2f2',
                    'borderColor' => '#9edede',
                ],
                [
                    'label' => __('Teachers Absence (in Hours)'),
                    'data' => $absenceData,
                    'backgroundColor' => '#ffe0e6',
                    'borderColor' => '#ff88a2',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getTeacherPresenceData()
    {
        $query = ClassSession::where('status', 'Completed')
            ->whereNotNull('teacher_enter_at')
            ->whereNotNull('teacher_exit_at')
            ->whereDate('date', '>=', $this->filters['start_date'] ?? now()->startOfYear())
            ->whereDate('date', '<=', $this->filters['end_date'] ?? now()->endOfYear());

        if ($this->filters['teacher_id']) {
            $query->where('teacher_id', $this->filters['teacher_id']);
        }

        $classSessions = $query->get();

        $attendancePerMonth = [];

        foreach ($classSessions as $session) {
            $enterAt = $session->teacher_enter_at;
            $exitAt = $session->teacher_exit_at;

            if ($exitAt->greaterThan($enterAt)) {

                $durationInMinutes = abs($exitAt->diffInMinutes($enterAt));
                $durationInHours = round($durationInMinutes / 60, 2);
                $month = $enterAt->format('Y-m');

                if (!isset($attendancePerMonth[$month])) {
                    $attendancePerMonth[$month] = 0;
                }
                $attendancePerMonth[$month] += $durationInHours;
            }
        }


        $data = array_fill(0, 12, 0);

        foreach ($attendancePerMonth as $month => $hours) {
            $monthIndex = (int) \Carbon\Carbon::parse($month)->format('n') - 1;
            $data[$monthIndex] = $hours;
        }

        return $data;
    }

    protected function getTeacherAbsenceData()
    {
        $query = ClassSession::whereIn('status', ['Absence', 'Enter_Only'])
            ->whereDate('date', '>=', $this->filters['start_date'] ?? now()->startOfYear())
            ->whereDate('date', '<=', $this->filters['end_date'] ?? now()->endOfYear());

        if ($this->filters['teacher_id']) {
            $query->where('teacher_id', $this->filters['teacher_id']);
        }

        $classSessions = $query->get();

        $attendancePerMonth = array_fill(0, 12, 0);

        foreach ($classSessions as $session) {

            $startTime = $session->actual_start_time;
            $endTime = $session->actual_end_time;
            $durationInHours = round(abs($endTime->diffInHours($startTime)));

            $monthIndex = (int) \Carbon\Carbon::parse($session->date)->format('n') - 1;
            $attendancePerMonth[$monthIndex] += $durationInHours;
        }

        return $attendancePerMonth;
    }

    public function getHeading(): string
    {
        return __('Attendance Chart');
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
