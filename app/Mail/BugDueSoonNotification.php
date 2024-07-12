<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Bugtracking;

class BugDueSoonNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bug;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Bugtracking $bug)
    {
        $this->bug = $bug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bug Due Date Approaching')
                    ->view('emails.bug_due_soon');
    }
}
