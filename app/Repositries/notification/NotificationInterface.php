<?php


namespace App\Repositries\notification;
interface NotificationInterface
{
    public function readNotification($id);
    public function getUnreadNotifications($type,$roleIdOrUserId);
    public function createNotification($notifyContent,$url,$orderId);
    public function createEndUserNotification($notifyContent,$url,$endUserId,$model,$orderId);
    public function getNotificationTemplate($statusId);
    public function storeUpdateNotificationTemplate($request);
}
