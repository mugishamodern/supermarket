<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use App\Mail\OrderApprovedAdmin;
use App\Mail\OrderApprovedClient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderApprovedEmails implements ShouldQueue
{
    public function handle(OrderApproved $event)
    {
        // Email to client
        Mail::to($event->order->user->email)->send(new OrderApprovedClient($event->order));

        // Email to admin (using config or a hardcoded admin email for now)
        Mail::to(config('mail.admin_address', 'admin@mukorasupermarket.com'))->send(new OrderApprovedAdmin($event->order));
    }
}