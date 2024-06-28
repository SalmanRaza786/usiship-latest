<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderStatus;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    private $appointment;
    private $wh;
    private $customField;
    public function __construct(AppointmentInterface $appointment , WhInterface $wh, CustomFieldInterface $customField) {
        $this->appointment = $appointment;
        $this->wh = $wh;
        $this->customField = $customField;

    }

    public function index(){
        try {
            $data['customerId']=Auth::id();
            $data['status']=OrderStatus::get();
            $data['selectStatus']=6;
            $data['createdBy']=Auth::id();
            $data['guard']='web';
            return view('client.screens.appointment.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }
    public function showAppointmentList(){
        try {
            $data['statuses']=$this->appointment->getAllStatus();
            return view('client.screens.appointment.show-list')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }
    public function appointmentList(Request $request){
        try {
            $res=$this->appointment->getAppointmentList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function edit($id)
    {
        try {

            $guards = array_keys(config('auth.guards'));
            $currentGuard = null;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $currentGuard = $guard;
                    break;
                }
            }
            if($currentGuard !='web'){
                $allow = 1;
            }else{
                $allow= $this->appointment->isAllowToModifyOrder($id);
            }
            if ($allow==1) {
                $res= $this->appointment->editAppointment($id);
                if($res->get('data')){
                    $data['load']=$res->get('data');
                    return Helper::ajaxSuccess($data,$res->get('message'));
                }else{
                    return Helper::error('Record not found');
                }
            }else
            {
                return Helper::error('Not Allow To Modify Please Contact Your System Administrator');
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function editScheduling($id)
    {
        try {
            $guards = array_keys(config('auth.guards'));
            $currentGuard = null;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $currentGuard = $guard;
                    break;
                }
            }

            if($currentGuard !='web'){
                $allow = 1;
            }else{
                $allow= $this->appointment->isAllowToModifyOrder($id);
            }

            if ($allow==1) {
            $res= $this->appointment->editAppointmentScheduling($id);
            if($res->get('data')){
                $data['order']=$res->get('data');
                $request = $res->get('data');
                $wh= $this->wh->getWareHousesWithOperationHour($request);
                $data['warehouse']=$wh->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
            }else
            {
                return Helper::error('Not Allow To Modify Please Contact Your System Administrator');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function update(Request $request){
        try {

            $roleUpdateOrCreate = $this->appointment->update($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function uploadPackagingList(Request $request){
        try {
            $roleUpdateOrCreate = $this->appointment->uploadPackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                $order = $this->appointment->changeOrderStatus($request->id,11);
                if($order->get('status')){
                    $data=$order->get('data');
                    $notification= $this->appointment->sendNotification($data->id,$data->customer_id,11,1);
                    if($notification->get('status')){
                        Helper::notificationTriggerHelper(1);

                    }
                }
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function updateScheduling(Request $request){
        try {

              $roleUpdateOrCreate = $this->appointment->updateScheduling($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                Helper::notificationTriggerHelper(1);
                Helper::notificationTriggerHelper(2);

                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function cancelAppointment($id)
    {
        try {
            $guards = array_keys(config('auth.guards'));
            $currentGuard = null;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $currentGuard = $guard;
                    break;
                }
            }

            if($currentGuard !='web'){
                $allow = 1;
            }else{
                $allow= $this->appointment->isAllowToModifyOrder($id);
            }

            if ($allow==1) {
                $res = $this->appointment->cancelAppointment($id);
                return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
            }else
            {
                return Helper::error('Not Allow To Modify Please Contact Your System Administrator');
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }






}
