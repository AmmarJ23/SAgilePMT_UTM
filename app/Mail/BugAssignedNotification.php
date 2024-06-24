<?php

namespace App\Mail;

use App\Bugtracking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BugAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bugtrack;

    /**
     * Create a new message instance.
     *
     * @param  Bugtracking  $bugtrack
     * @return void
     */
    public function __construct(Bugtracking $bugtrack)
    {
        $this->bugtrack = $bugtrack;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bug Assigned Notification')
                    ->markdown('emails.bug_assigned_notification');
    }
}

