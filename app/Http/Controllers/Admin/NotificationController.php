<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\notification\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notification;
    private $order;

    public function __construct(NotificationInterface $notification ,AppointmentInterface $order) {
        $this->notification = $notification;
        $this->order = $order;

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
            $type=$request->type;
            $notifiableId=$request->notifiableId;
            $res=Helper::fetchOnlyData($this->notification->getUnreadNotifications($type,$notifiableId));
            return Helper::success($res,'Unread notifications list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function index()
    {
        try {
            $data['status']=Helper::fetchOnlyData($this->order->getAllStatus());
            return view('admin.notification.index')->with(compact('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //createTemplate
    public function createTemplate(Request $request)
    {
        try {
            $id= decrypt($request->query('id'));
            $status=Helper::fetchOnlyData($this->order->getAllStatus());
            $data['statusTitle']=$status->where('id',$id)->pluck('status_title')->first();
            $data['id']=$id;
            $data['template']=$this->notification->getNotificationTemplate($id);
            return view('admin.notification.create')->with(compact('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function storeTemplate(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->notification->storeUpdateNotificationTemplate($request);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
            }
    }
}
