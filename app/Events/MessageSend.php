<?php

namespace App\Events;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        /**
         * you can return Private or Precence Channel
         * and you need add this channel into channel route file
         */
        return [
            // new PrivateChannel('channel-messages'),
            new PresenceChannel('channel-messages' . $this->message->recipient_id)
        ];
    }

    public function broadcastAs()
    {
        return 'message.created';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'user' => Auth::user()->name,
            'time' => Carbon::now()->diffForHumans()
        ];
    }
}
