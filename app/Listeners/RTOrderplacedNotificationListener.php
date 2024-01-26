<?php

namespace App\Listeners;

use App\Events\RTOrderplacedNotificationEvent;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RTOrderplacedNotificationListener
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
    public function handle(RTOrderplacedNotificationEvent $event): void
    {
        $notification = new OrderPlacedNotification();
        $notification->message = $event->message;
        $notification->order_id = $event->order_id;
        $notification->save();
    }
}
