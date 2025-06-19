<?php

namespace App\Listeners;

use App\Events\ContactInquiryReplied;
use App\Mail\ContactInquiryReply;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactInquiryReplyEmail implements ShouldQueue
{
    public function handle(ContactInquiryReplied $event)
    {
        Mail::to($event->contactInquiry->email)->send(new ContactInquiryReply($event->contactInquiry, $event->reply));
        Mail::to(config('mail.admin_address', 'admin@mukorasupermarket.com'))->send(new ContactInquiryReply($event->contactInquiry, $event->reply));
    }
}