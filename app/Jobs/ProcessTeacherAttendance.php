<?php

namespace App\Jobs;

use App\Helper\Helper;
use App\Models\ClassSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTeacherAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $classSession;

    public function __construct(ClassSession $classSession)
    {
        $this->classSession = $classSession;
    }

    public function handle()
    {
        $this->classSession->teacher_delay = Helper::setTeacherDelay($this->classSession);
        $this->classSession->teacher_hurry = Helper::setTeacherHurry($this->classSession);
        $this->classSession->save();
    }
}
