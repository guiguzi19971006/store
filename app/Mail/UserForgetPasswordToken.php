<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserForgetPasswordToken extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_token)
    {
        $this->user_token = $user_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.forget_password_token')->with([
            'token_content' => $this->user_token->content
        ]);
    }
}
