<?php

namespace App\Providers;

use App\Events\OrderApproved;
use App\Listeners\SendOrderApprovedEmails;
use App\Events\ContactInquiryReplied;
use App\Listeners\SendContactInquiryReplyEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderApproved::class => [
            SendOrderApprovedEmails::class,
        ],
        ContactInquiryReplied::class => [
            SendContactInquiryReplyEmail::class,
        ],
    ];

    public function boot()
    {
        //
    }
}