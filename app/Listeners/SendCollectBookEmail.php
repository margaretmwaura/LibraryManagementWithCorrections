<?php

namespace App\Listeners;

use App\Events\BookReturned;
use App\Mail\collectbook;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCollectBookEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookReturned  $event
     * @return void
     */
    public function handle(BookReturned $event)
    {
        Mail::to($event->user->email)->send(new collectbook($event->user,$event->book));
    }
}
