<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // These properties will hold the file data in a serializable format.
    public array $file = [];
    public array $image = [];

    /**
     * TestEmail constructor.
     *
     * @param array $data The data array containing email details.
     *                    - 'file' (optional): An instance of UploadedFile representing the file to be attached.
     *                    - 'image' (optional): An instance of UploadedFile representing the image to be attached.
     *
     * This constructor processes the provided 'file' and 'image' if they are instances of UploadedFile.
     * It encodes the contents of the file and image to base64, retrieves their MIME types and original names,
     * and stores them in the $file and $image properties respectively. The UploadedFile instances are then
     * removed from the $data array to avoid serialization issues.
     */
    public function __construct(public array $data)
    {
        // Process the 'file' if provided
        if (isset($this->data['file']) && $this->data['file'] instanceof UploadedFile) {
            $uploadedFile = $this->data['file'];
            $this->file = [
                'contents' => base64_encode($uploadedFile->get()),
                'mime'     => $uploadedFile->getClientMimeType(),
                'name'     => $uploadedFile->getClientOriginalName(),
            ];
            // Remove the UploadedFile instance to avoid serialization issues
            unset($this->data['file']);
        }

        // Process the 'image' if provided
        if (isset($this->data['image']) && $this->data['image'] instanceof UploadedFile) {
            $uploadedImage = $this->data['image'];
            $this->image = [
                'contents' => base64_encode($uploadedImage->get()),
                'mime'     => $uploadedImage->getClientMimeType(),
                'name'     => $uploadedImage->getClientOriginalName(),
            ];
            // Remove the UploadedFile instance to avoid serialization issues
            unset($this->data['image']);
        }
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

        $attachment = [];

        if (!empty($this->file)) {
            $attachment[] = Attachment::fromData(fn() => base64_decode($this->file['contents']), $this->file['name'])
                    ->withMime($this->file['mime']);
        }

        if (!empty($this->image)) {
            $attachment[] = Attachment::fromData(fn() => base64_decode($this->image['contents']), $this->image['name'])
                    ->withMime($this->image['mime']);
        }

        return $attachment;
    }
}
