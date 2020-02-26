<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class collectbook extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $book;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$book)
    {
        $this->user = $user;
        $this->book = $book;
    }

    public function build()
    {
        return $this->view('collection');
    }
}
