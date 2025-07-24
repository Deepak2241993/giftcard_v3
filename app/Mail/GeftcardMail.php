<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\GiftcardsNumbers;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate; // Import the correct namespace for the model

class GeftcardMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_data;

    public function __construct($mail_data)
    {
      
        if(isset($mail_data[0]['template_id']) && $mail_data[0]['template_id']!=0)
        {
            $id = $mail_data[0]['template_id'];
            $template = EmailTemplate::find($id); // Use the correct model namespace
            $mail_data['html_code']=$template['html_code'];
            $mail_data['subject']=$template['subject'];
            $this->mail_data = $mail_data;
            
        }
        else{
                       
            $this->mail_data = $mail_data;
        }
        
        
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */

    public function envelope()
    {
        // dd($this->mail_data);
       if(!empty($this->mail_data['subject']))
       {
        return new Envelope(
            subject: $this->mail_data['subject'],
        );
       }
       else{
        return new Envelope(
            subject: 'Medspa Gift Card',
        );
       }
       
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.giftcard'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
