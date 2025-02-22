<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Enum\Status;
use App\Helper\General;
use App\Models\ClassTime;
use App\Models\ClassSession;
use App\Models\ClassSchedule;

class ClassTimeObserver
{
    public function created(ClassTime $classTime): void
    {
        $classSchedule = $classTime->classSchedule;
        $term = $classSchedule->term;

        $startDate = Carbon::parse($term->start_date);
        $endDate = Carbon::parse($term->end_date);
        $sessionsNumber = $term->sessions_number;
        $dayOfWeek = $classTime->day;

        switch ($classTime->type) {
            case 'static':
                $this->createStaticSessions($classSchedule, $classTime, $startDate, $endDate, $sessionsNumber, $dayOfWeek);
                break;
            case 'odd':
            case 'even':
                $this->createOddEvenSessions($classSchedule, $classTime, $startDate, $endDate, $sessionsNumber, $dayOfWeek);
                break;
            default:
                throw new \InvalidArgumentException("Invalid class type: {$classTime->type}");
        }
    }

    protected function createStaticSessions(ClassSchedule $classSchedule, ClassTime $classTime, Carbon $startDate, Carbon $endDate, int $sessionsNumber, int $dayOfWeek): void
    {
        $currentDate = $startDate->copy();
        $createdSessions = 0;

        while ($currentDate <= $endDate && $createdSessions < $sessionsNumber) {
            if ($currentDate->dayOfWeek == $dayOfWeek) {
                ClassSession::create([
                    'name' => $classSchedule->name . '-جلسه ' . ' ' . $createdSessions,
                    'teacher_id' => $classSchedule->teacher_id,
                    'class_time_id' => $classTime->id,
                    'actual_start_time' => $classTime->start_time,
                    'actual_end_time' => $classTime->end_time,
                    'date' => $currentDate->toDateString(),
                    'status' => Status::Scheduled->value
                ]);
                $createdSessions++;
            }
            $currentDate->addDay();
        }

        if ($createdSessions < $sessionsNumber) {
            throw new \RuntimeException("Not enough dates to create all sessions. Required: {$sessionsNumber}, Created: {$createdSessions}");
        }
    }

    protected function createOddEvenSessions(ClassSchedule $classSchedule, ClassTime $classTime, Carbon $startDate, Carbon $endDate, int $sessionsNumber, int $dayOfWeek): void
    {
        $currentDate = $startDate->copy();
        $createdSessions = 0;
        $requiredSessions = ceil($sessionsNumber / 2);

        while ($currentDate <= $endDate && $createdSessions < $requiredSessions) {
            if ($currentDate->dayOfWeek == $dayOfWeek) {
                $weekParity = General::getWeekParity($startDate, $endDate, $currentDate);
                if (($classTime->type == 'odd' && $weekParity == 'odd') || ($classTime->type == 'even' && $weekParity == 'even')) {
                    ClassSession::create([
                        'name' => $classSchedule->name . '-جلسه ' . ' ' . $createdSessions,
                        'teacher_id' => $classSchedule->teacher_id,
                        'class_time_id' => $classTime->id,
                        'actual_start_time' => $classTime->start_time,
                        'actual_end_time' => $classTime->end_time,
                        'date' => $currentDate->toDateString(),
                        'status' => Status::Scheduled->value,
                    ]);
                    $createdSessions++;
                }
            }
            $currentDate->addDay();
        }

        // if ($createdSessions < $requiredSessions) {
        //     throw new \RuntimeException("Not enough dates to create all sessions. Required: {$requiredSessions}, Created: {$createdSessions}");
        // }
    }


    /**
     * Handle the ClassTime "updated" event.
     */
    public function updated(ClassTime $classTime): void
    {
        //
    }

    /**
     * Handle the ClassTime "deleted" event.
     */
    public function deleted(ClassTime $classTime): void
    {
        //
    }

    /**
     * Handle the ClassTime "restored" event.
     */
    public function restored(ClassTime $classTime): void
    {
        //
    }

    /**
     * Handle the ClassTime "force deleted" event.
     */
    public function forceDeleted(ClassTime $classTime): void
    {
        //
    }
}
