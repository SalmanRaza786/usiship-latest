<?php
namespace App\Repositries\notification;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\OperationalHour;
use App\Models\OrderBookedSlot;
use App\Models\WareHouse;
use App\Models\WhAssignedField;
use App\Models\WhOffDay;
use App\Models\WhOperationHour;
use App\Models\WhWorkingHour;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PHPUnit\TextUI\Help;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class NotificationRepositry implements NotificationInterface
{

    public function readNotification($id)
    {
        try {
            $notification = Notification::find($id);
            $notification->is_read = 1;
            $notification->save();
            return Helper::success($notification, 'Notification read successfully');

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(), []);
        }

    }

    public function getUnreadNotifications($type,$notifiableId=null,$limit=null)
    {
        try {


            //if user type ==1 then $roleIdOrUserId is role_id else $roleIdOrUserId mean customer id
            $qry = Notification::query();
            if($type==1){
                $qry=$qry->where('notifiable', 'App\Models\Admin')->where('notifiable_id',$notifiableId)->where('notifiType',1);
            }
            if($type==2){
                $qry=$qry->where('notifiable', 'App\Models\User')->where('notifiable_id',$notifiableId)->where('notifiType',2);
            }
            $qry=$qry->where('is_read', 2);
            ($limit > 0)? $qry=$qry->take($limit):'';
            $qry=$qry->orderByDesc('id');
            $notification=$qry->get();

            if ($notification->count() > 0) {
                $notifiData = collect([]);
                foreach ($notification as $row) {
                    $notifiArray = array(
                        'id' => $row->id,
                        'content' => $row->content,
                        'created_at' => $row->created_at->diffForHumans(),
                        'notifiType' => $row->notifiType,
                        'notifiableId' => $row->notifiable_id,
                        'target_model_id' => $row->target_model_id,
                        'url' => $row->url
                    );
                    $notifiData->push($notifiArray);
                }
            }
            return Helper::success($notifiData, 'Unread notifications list');

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(), []);
        }

    }

    public function createNotification($notifyContent,$url,$orderId)
    {
        try {
            $permission = Permission::where('name', 'admin-notification-view')->first();
            $hasPermissions = DB::table('role_has_permissions')->where('permission_id', $permission->id)->get();
            if ($hasPermissions->count() > 0) {

                foreach ($hasPermissions as $row) {


                    $users = Admin::where('role_id', $row->role_id)->get();
                    foreach ($users as $user) {

                        $notification = \App\Models\Notification::updateOrCreate(
                            [
                                'id' => 0,
                            ],
                            [
                                'content' => $notifyContent->notify_content,
                                'notifiable' => 'App\Models\Admin',
                                'notifiable_id' =>$user->id,
                                'target_model_id' =>$orderId,
                                'url' => $url,
                            ]
                        );
                    }
                }
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function createEndUserNotification($notifyContent,$url,$endUserId,$model,$orderId=null)
    {
        try {
                    $notification =Notification::updateOrCreate(
                        [
                            'id' => 0,
                        ],
                        [
                            'content' => $notifyContent->notify_content,
                            'notifiable_id' =>$endUserId,
                            'notifiable' =>$model,
                            'target_model_id' =>$orderId,
                            'notifiType' => 2,
                            'url' => $url,
                        ]
                    );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getNotificationTemplate($statusId)
    {
        try {
        return $res=  NotificationTemplate::where('status_id',$statusId)->latest('id')->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function storeUpdateNotificationTemplate($request)
    {
        try {
            $notification =NotificationTemplate::updateOrCreate(
                [
                    'status_id' => $request->status_id,
                ],
                [
                    'status_id' => $request->status_id,
                    'mail_content' =>$request->editorContent,
                    'sms_content' =>$request->sms_content,
                    'notify_content' =>$request->notify_content,
                ]
            );

            return Helper::success($notification,'template save successfully');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}





