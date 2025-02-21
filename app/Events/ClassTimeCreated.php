<?php

namespace App\Events;

use App\Models\ClassTime;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ClassTimeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $classTime;
    
    public function __construct(ClassTime $classTime)
    {
        $this->classTime = $classTime;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
