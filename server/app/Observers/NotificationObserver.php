<?php

namespace App\Observers;

use App\Notification;

class NotificationObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  Notification  $notification
     * @return void
     */
    public function creating(Notification $notification)
    {
        // get current user
        $admin = auth()->guard('admin')->user();
        $notification->created_by = $admin->id;
    }

    /**
     * Listen to the User upd9ating event.
     *
     * @param  Notification  $notification
     * @return void
     */
    public function updating(Notification $notification)
    {
        // get current user
        $admin = auth()->guard('admin')->user();
        $notification->updated_by = $admin->id;
    }
}