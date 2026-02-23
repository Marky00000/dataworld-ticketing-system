<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS', 'ticket-support@dataworld.com.ph'), env('MAIL_FROM_NAME', 'Dataworld Support')),
            subject: 'Welcome to Dataworld Support Portal',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.welcome',
        );
    }

     public function build()
    {
        $mailer = $this->user->email && str_contains($this->user->email, '@gmail.com') 
            ? 'gmail' 
            : 'outlook';
            
        return $this->from(
            $mailer === 'gmail' ? env('GMAIL_FROM_ADDRESS') : env('OUTLOOK_FROM_ADDRESS'),
            'Dataworld Support'
        )->subject('Welcome to Dataworld Support Portal')
         ->view('email.welcome');
    }
}