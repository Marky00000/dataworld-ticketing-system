<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
// Remove this import: use Illuminate\Contracts\Queue\ShouldQueue;

class TicketCreatedMail extends Mailable // Remove implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketUrl;
    public $supportEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->ticketUrl = route('tickets.show', $ticket->id);
        $this->supportEmail = 'ticket-support@dataworld.com.ph';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address', 'ticket-support@dataworld.com.ph'),
                config('mail.from.name', 'Dataworld Support')
            ),
            to: [
                new Address('ticket-support@dataworld.com.ph', 'Dataworld Support Team'),
            ],
            subject: '🎫 New Support Ticket: ' . $this->ticket->ticket_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.ticket-created',
            with: [
                'ticket' => $this->ticket,
                'ticketUrl' => $this->ticketUrl,
                'supportEmail' => $this->supportEmail,
                'createdAt' => $this->ticket->created_at->format('F j, Y \a\t g:i A'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}