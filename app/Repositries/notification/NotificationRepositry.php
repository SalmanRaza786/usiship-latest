<?php
namespace App\Repositries\notification;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\Notification;
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

    public function getUnreadNotifications($type,$notifiableId=null)
    {
        try {


            //if user type ==1 then $roleIdOrUserId is role_id else $roleIdOrUserId mean customer id
            $qry = Notification::query();
            if($type==1){
                $qry=$qry->where('notifiable', 'App\Models\Admin')->where('role_id',$notifiableId);
            }
            if($type==2){
                $qry=$qry->where('notifiable', 'App\Models\User')->where('notifiable_id',$notifiableId);
            }
            $qry=$qry->where('is_read', 2);
            $qry=$qry->orderByDesc('id');
            $notification=$qry->get();

            if ($notification->count() > 0) {
                $notifiData = collect([]);
                foreach ($notification as $row) {
                    $notifiArray = array(
                        'id' => $row->id,
                        'content' => $row->content,
                        'created_at' => $row->created_at->diffForHumans(),
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

    public function createNotification($notifyContent,$url)
    {
        try {
            $permission = Permission::where('name', 'admin-notification-view')->first();
            $hasPermissions = DB::table('role_has_permissions')->where('permission_id', $permission->id)->get();
            if ($hasPermissions->count() > 0) {

                foreach ($hasPermissions as $row) {
                    $notification = \App\Models\Notification::updateOrCreate(
                        [
                            'id' => 0,
                        ],
                        [
                            'content' => $notifyContent->notify_content,
                            'notifiable' => 'App\Models\Admin',
                            'role_id' => $row->role_id,
                            'url' => $url,
                        ]
                    );
                }
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function createEndUserNotification($notifyContent,$url,$endUserId,$model)
    {
        try {
                    $notification = \App\Models\Notification::updateOrCreate(
                        [
                            'id' => 0,
                        ],
                        [
                            'content' => $notifyContent->notify_content,
                            'notifiable_id' =>$endUserId,
                            'notifiable' =>$model,
                            'url' => $url,
                        ]
                    );
        } catch (\Exception $e) {
            throw $e;
        }
    }
}





