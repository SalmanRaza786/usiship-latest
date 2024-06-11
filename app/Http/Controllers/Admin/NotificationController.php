<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\notification\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notification;

    public function __construct(NotificationInterface $notification) {
        $this->notification = $notification;

    }
    public function readNotification($id)
    {
        try {
        $res=$this->notification->readNotification($id);
        return Helper::success([],$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function getUnreadNotifications(Request $request)
    {
        try {
            $res=Helper::fetchOnlyData($this->notification->getUnreadNotifications($request->type));
            return Helper::success($res,'Unread notifications list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
