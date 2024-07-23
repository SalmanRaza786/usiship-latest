<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Notification;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    private $notification;

    public function __construct(NotificationInterface $notification) {
        $this->notification = $notification;
    }

    public function getUnreadNotifications(Request $request)
    {
        try {
            $type=$request->type;
            $notifiableId=$request->notifiableId;

            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'notifiableId' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $res=Helper::fetchOnlyData($this->notification->getUnreadNotifications($type,$notifiableId));
            return  Helper::createAPIResponce(false,200,'Unread notifications list',$res);

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }

    public function readNotification(Request $request)
    {
        try {
            $id=$request->query('notificationId');
            if (!Notification::find($id)) {
                return  Helper::createAPIResponce(true,400,'Invalid notification id',[]);
            }
            $res=$this->notification->readNotification($id);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res);

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
