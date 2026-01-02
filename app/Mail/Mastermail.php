<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;

class Mastermail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildata;
    protected $template;

    /**
     * Create a new message instance.
     */
    public function __construct($maildata, $template_id)
    {
        $this->maildata = $maildata;
        $this->template = EmailTemplate::findOrFail($template_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd($this->maildata);
        return new Content(
            view: 'email.mastermail',
            with: [
                'maildata' => $this->maildata,
                'template' => $this->template,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
