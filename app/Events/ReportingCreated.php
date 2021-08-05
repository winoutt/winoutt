<?php

namespace App\Events;

use App\Reporting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportingCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reporting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reporting $reporting)
    {
        $this->reporting = $reporting;
    }

    public function broadcastAs()
    {
        return 'reporting.created';
    }

    public function broadcastWith()
    {
        return ['reporting_id' => $this->reporting->id];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('reporting');
    }
}