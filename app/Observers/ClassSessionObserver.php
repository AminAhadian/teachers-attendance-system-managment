<?php

namespace App\Observers;

use App\Jobs\ProcessTeacherAttendance;
use Carbon\Carbon;
use App\Models\ClassSession;

class ClassSessionObserver
{
    /**
     * Handle the ClassSession "created" event.
     */
    public function created(ClassSession $classSession): void
    {
        //
    }

    /**
     * Handle the ClassSession "updated" event.
     */
    public function updated(ClassSession $classSession): void
    {

    }

    /**
     * Handle the ClassSession "deleted" event.
     */
    public function deleted(ClassSession $classSession): void
    {
        //
    }

    /**
     * Handle the ClassSession "restored" event.
     */
    public function restored(ClassSession $classSession): void
    {
        //
    }

    /**
     * Handle the ClassSession "force deleted" event.
     */
    public function forceDeleted(ClassSession $classSession): void
    {
        //
    }
}
