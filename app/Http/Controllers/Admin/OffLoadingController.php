<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderOffLoading;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class OffLoadingController extends Controller
{
    private $offloaing;
    private $checkin;
    private $appointment;


    public function __construct(OffLoadingInterface $offloaing, CheckinInterface $checkin, AppointmentInterface $appointment) {
         $this->offloaing = $offloaing;
         $this->checkin = $checkin;
         $this->appointment = $appointment;
    }

    public function index(){
        try {
            return view('admin.offloading.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function packagingListConfirmation($id){
        try {
             $data = Helper::fetchOnlyData($this->offloaing->findOffloadingByCheckInId($id));
            return view('admin.offloading.confirm-packaging-list')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function offLoadingDetail($id)
    {
        try {
            $data = Helper::fetchOnlyData($this->checkin->findCheckIn($id));
            return view('admin.offloading.detail')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function offLoadingList(Request $request){
        try {
            $res=$this->offloaing->getOffLoadingList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function offLoadingCreateOrUpdate(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offloaing->offLoadingSave($request,$request->order_checkin_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function offLoadingUpdate(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offloaing->offLoadingUpdate($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function saveOffLoadingImages(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offloaing->offLoadingImagesSave($request,$request->off_loading_id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function checkOrderCheckInId(Request $request)
    {
        try {
             $res= $this->offloaing->checkOrderCheckInId($request);
            if($res->get('status'))
            {
                $data=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //offloadingStatusChange
    public function offloadingStatusChange($id)
    {
        try {
            $res= $this->offloaing->changeOffLoadingStatus($id,10);

            $offLoading=OrderOffLoading::with('order')->find($id);

            $orderId=$offLoading->id;
            $statusId=10;

            $order =$this->appointment->changeOrderStatus($orderId,$statusId);

            //1 for admin 2 for user
             $this->appointment->sendNotification($orderId,$offLoading->customer_id,$statusId,1);
             $this->appointment->sendNotification($orderId,$offLoading->customer_id,$statusId,2);
            Helper::notificationTriggerHelper(1);
            Helper::notificationTriggerHelper(2);

           return Helper::success($res->get('data'),'status changed');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
