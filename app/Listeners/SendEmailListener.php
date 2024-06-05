<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendEmailEvent $event)
    {
        try {

            Notification::send($event->user, new OrderNotification($event->mailData));
            Log::info('Order notification sent successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to send order notification: ' . $e->getMessage());
        }
    }
}
