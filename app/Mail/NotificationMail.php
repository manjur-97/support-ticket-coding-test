<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailDetails;

    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }



    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->mailDetails['status'] == 'open') {
            return new Envelope(
                subject: $this->mailDetails['issue_title'],
            );
        } else {
            return new Envelope(
                subject: "Your ticket is close",
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->mailDetails['status'] == 'open') {
            return new Content(
                view: 'email_content',
                with: [
                    'description' => $this->mailDetails['description'],
                    'customer_id' => $this->mailDetails['customer_id'],
                    'customer_name' => $this->mailDetails["customer_name"],
                    'status' => 'open',
                ],
            );
        } else {
            return new Content(
                view: 'email_content',
                with: [
                    'feedback' => $this->mailDetails['feedback'],
                    'status' => 'closed',


                ],
            );
        }
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
