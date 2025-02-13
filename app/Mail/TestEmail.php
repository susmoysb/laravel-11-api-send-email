<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $data)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('support@example.com', 'Support'),
            replyTo: [
                new Address('contact@example.com', 'Contact'),
            ],
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // return [
        //     Attachment::fromPath('C:\Users\susmoy\Documents\Annual Holiday Calendar 2025.pdf')
        //         ->as('doc.pdf')
        //         ->withMime('application/pdf'),
        // ];

        $file = $this->data['file'];
        return [
            Attachment::fromData(fn() => $file->get(), $file->getClientOriginalName())
                ->withMime($file->getClientMimeType()),
        ];
    }
}
