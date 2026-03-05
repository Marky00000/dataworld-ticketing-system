<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $sender;
    public $messageContent;  // CHANGED: from $message to $messageContent
    public $isTechSender;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, User $sender, $messageContent, $isTechSender = false)
    {
        $this->ticket = $ticket;
        $this->sender = $sender;
        $this->messageContent = $messageContent;  // CHANGED: use different name
        $this->isTechSender = $isTechSender;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isTechSender 
            ? '🔧 Support replied to your ticket #' . $this->ticket->ticket_number
            : '💬 New message on ticket #' . $this->ticket->ticket_number . ' from ' . $this->sender->name;
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.new-message',
        );
    }
}