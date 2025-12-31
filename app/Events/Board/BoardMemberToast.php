<?php

namespace App\Events\Board;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BoardMemberToast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userId;
    public array $toast;

    public function __construct(int $userId, array $toast)
    {
        $this->userId = $userId;
        $this->toast = $toast;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs() {
        return('BoardMemberToast');
    }

    public function broadcastWith() {
        return $this->toast;
    }
}
