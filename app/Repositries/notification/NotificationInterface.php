<?php


namespace App\Repositries\notification;
interface NotificationInterface
{
    public function readNotification($id);
    public function getUnreadNotifications();

    public function createNotification($notifyContent,$url);
}
