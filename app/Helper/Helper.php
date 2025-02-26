<?php

namespace App\Helper;

use Carbon\Carbon;
use App\Models\ClassSession;
use Illuminate\Support\Facades\Log;


class Helper
{
    public static function generateAttendanceCode($key)
    {
        $hash = md5($key);
        $code = substr(preg_replace('/[^0-9]/', '', $hash), 0, 10);
        return $code;
    }

    public static function getWeekParity($start_date, $end_date, $current_date)
    {
        $start_date = \Carbon\Carbon::parse($start_date);
        $end_date = \Carbon\Carbon::parse($end_date);
        $current_date = \Carbon\Carbon::parse($current_date);

        if ($current_date->lt($start_date)) {
            return "Current date is before the start date.";
        }
        if ($current_date->gt($end_date)) {
            return "Current date is after the end date.";
        }

        $weekDifference = $start_date->diffInWeeks($current_date);

        if ($weekDifference % 2 === 0) {
            return "Odd Week";
        } else {
            return "Even Week";
        }
    }

    public static function parseClassTimeString(string $input): array
    {
        $input = trim($input);
        $parts = array_map('trim', explode('؛', $input));

        $results = [];

        foreach ($parts as $part) {
            if (empty($part)) {
                continue;
            }

            preg_match('/([^\d]+)\s+(\d{2}:\d{2})\s+تا\s+(\d{2}:\d{2})/', $part, $matches);

            if (count($matches) < 4) {
                throw new \InvalidArgumentException("Invalid input format: {$part}");
            }

            $dayString = trim($matches[1]);
            $startTime = $matches[2];
            $endTime = $matches[3];

            // Convert Persian day name to Carbon day integer
            $dayMap = [
                'شنبه' => Carbon::SATURDAY,
                'یکشنبه' => Carbon::SUNDAY,
                'دوشنبه' => Carbon::MONDAY,
                'سه‌شنبه' => Carbon::TUESDAY,
                'چهارشنبه' => Carbon::WEDNESDAY,
                'پنج شنبه' => Carbon::THURSDAY,
                'جمعه' => Carbon::FRIDAY,
            ];

            if (!isset($dayMap[$dayString])) {
                throw new \InvalidArgumentException("Invalid day name: {$dayString}");
            }

            $day = $dayMap[$dayString];

            if (count($parts) === 1) {
                $results[] = [
                    'day' => $day,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'type' => 'static',
                ];
            } else {
                if (empty($results)) {
                    $results[] = [
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'type' => 'static',
                    ];
                } else {
                    $startHour = (int) explode(':', $startTime)[0];
                    $type = ($startHour % 2 === 0) ? 'even' : 'odd';

                    $endTime = Carbon::createFromFormat('H:i', $startTime)
                        ->addHours(2)
                        ->format('H:i');

                    $results[] = [
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'type' => $type,
                    ];
                }
            }
        }

        return $results;
    }

    public static function setTeacherDelay(ClassSession $classSession)
    {
        $classStartTime = $classSession->actual_start_time;
        $teacherEnterAt = $classSession->teacher_enter_at;

        if ($teacherEnterAt && $teacherEnterAt->gt($classStartTime)) {
            return abs($teacherEnterAt->diffInMinutes($classStartTime));
        }

        return null;
    }

    public static function setTeacherHurry(ClassSession $classSession)
    {
        $classEndTime = $classSession->actual_end_time;
        $teacherExitAt = $classSession->teacher_exit_at;

        if ($teacherExitAt && $teacherExitAt->lt($classEndTime)) {
            return abs($classEndTime->diffInMinutes($teacherExitAt));
        }

        return null;
    }

    public static function convertMinutesToHoursMinutes(int $minutes): string
    {
        $time = Carbon::now()->startOfDay()->addMinutes($minutes);

        return $time->format('G\h i\m');
    }
}
