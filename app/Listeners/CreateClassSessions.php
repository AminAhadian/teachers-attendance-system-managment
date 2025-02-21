<?php

namespace App\Listeners;

use App\Events\ClassTimeCreated;
use App\Helper\General;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateClassSessions
{

    public function __construct() {}


    public function handle(ClassTimeCreated $event): void
    {
        dd($event->class_id);
    }
}
