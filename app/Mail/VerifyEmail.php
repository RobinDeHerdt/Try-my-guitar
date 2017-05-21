<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * Create a new VerifyEmail instance.
     *
     * @param \App\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administrator@tmg.com')
            ->view('emails.verify')
            ->with([
                'user' => $this->user,
            ]);
    }
}
