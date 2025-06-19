<?php

namespace App\Events;

use App\Models\ContactInquiry;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactInquiryReplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contactInquiry;
    public $reply;

    public function __construct(ContactInquiry $contactInquiry, $reply)
    {
        $this->contactInquiry = $contactInquiry;
        $this->reply = $reply;
    }
}