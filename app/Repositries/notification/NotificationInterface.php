<?php


namespace App\Repositries\notification;
interface NotificationInterface
{
    public function readNotification($id);
    public function getUnreadNotifications($type);
    public function createNotification($notifyContent,$url);
    public function createEndUserNotification($notifyContent,$url,$endUserId,$model);
}
