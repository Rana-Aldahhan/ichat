<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message=$message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->message->sender_id.'.'.$this->message->receiver_id);
    }
    public function broadcastWith()
    {
        return [
            'body' => $this->message->body,
            'created_at' => $this->message->created_at->diffForHumans(),
            'sender' => [
              'name' => $this->message->sender->name,
              'profile'=>$this->message->sender->profile,
            ],
            'receiver'=>[
                'name' => $this->message->receiver->name,
                'profile'=>$this->message->receiver->profile,
            ]
          ];
    }
}
