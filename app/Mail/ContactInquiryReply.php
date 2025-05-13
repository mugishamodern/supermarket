<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactInquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public $contactInquiry;
    public $reply;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactInquiry $contactInquiry, string $reply)
    {
        $this->contactInquiry = $contactInquiry;
        $this->reply = $reply;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Mukora Supermarket - Response to Your Inquiry')
            ->markdown('emails.contact-inquiry-reply')
            ->with([
                'name' => $this->contactInquiry->name,
                'originalMessage' => $this->contactInquiry->message,
                'reply' => $this->reply,
            ]);
    }
}