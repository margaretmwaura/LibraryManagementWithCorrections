<?php

namespace App\Events;

use App\Models\Book;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookReturned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public $user;
    public $book;
    public function __construct(User $user , Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
