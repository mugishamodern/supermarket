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

    public function __construct(ContactInquiry $contactInquiry, $reply)
    {
        $this->contactInquiry = $contactInquiry;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Mukora Supermarket: Response to Your Inquiry')
                    ->markdown('emails.contact-inquiry-reply')
                    ->with([
                        'name' => $this->contactInquiry->name,
                        'originalMessage' => $this->contactInquiry->message,
                        'reply' => $this->reply,
                    ]);
    }
}