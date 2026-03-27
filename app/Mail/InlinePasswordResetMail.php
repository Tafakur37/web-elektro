<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InlinePasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.inline_reset',
        );
    }

    public function build()
    {
        return $this->subject('Reset Password - Web Elektro')
                    ->view('mail.inline_reset');
    }
}

