<?php

namespace App\Observers;

use App\Helper\General;
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
    public function updating(ClassSession $classSession): void
    {
        // dd(General::setTeacherDelay($classSession));
        if (in_array($classSession->status, ['Completed'])) {
            $classSession->teacher_delay = General::setTeacherDelay($classSession);
        }
        $classSession->save();
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
