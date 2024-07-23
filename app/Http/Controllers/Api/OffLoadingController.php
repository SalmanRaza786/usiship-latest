<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderCheckIn;
use App\Models\OrderOffLoading;

use App\Repositries\appointment\AppointmentInterface;

use App\Models\PackgingList;

use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\packagingList\PackagingListRepositry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OffLoadingController extends Controller
{
    private $offloaing;
    private $checkin;
    private $packging;
    private $appointment;


    public function __construct(OffLoadingInterface $offloaing, CheckinInterface $checkin,PackagingListRepositry $packging,AppointmentInterface $appointment) {
        $this->offloaing = $offloaing;
        $this->checkin = $checkin;
        $this->packging = $packging;
        $this->appointment = $appointment;
    }
    public function offLoadingCreateOrUpdate(Request $request)
    {
        try {
            if (!OrderCheckIn::find($request->order_checkin_id)) {
                return  Helper::createAPIResponce(true,400,'Invalid Checkin id',[]);
            }
            $roleUpdateOrCreate = $this->offloaing->offLoadingSave($request,$request->order_checkin_id);
            if ($roleUpdateOrCreate->get('status'))
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function closeOffLoading(Request $request)
    {
        try {
            if (!OrderOffLoading::find($request->id)) {
                return  Helper::createAPIResponce(true,400,'Invalid offloading id',[]);
            }
            $roleUpdateOrCreate = $this->offloaing->offLoadingUpdate($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function packagingListConfirmation(Request $request){

        try {
            if (!OrderCheckIn::find($request->checkin_id)) {
                return  Helper::createAPIResponce(true,400,'Invalid Checkin id',[]);
            }
            $roleUpdateOrCreate = $this->offloaing->findOffloadingByCheckInId($request->checkin_id);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }
        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function saveOffLoadingImages(Request $request)
    {
        try {
             $request->all();

             if(!OrderOffLoading::find($request->offloadingId)){
                 return  Helper::createAPIResponce(true,400,'Invalid offloading Id',[]);
             }
            $roleUpdateOrCreate = $this->offloaing->offLoadingImagesSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function checkOrderCheckInId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_checkin_id' =>'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $res= $this->offloaing->checkOrderCheckInId($request);
            if($res->get('data') != null)
            {
                return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
            }else{
                $data = [

                ];
                return  Helper::createAPIResponce(false,200,"Order checkin id not found", (object)[]);
            }

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }


    public function closeItemPutAway(Request $request)
    {
        try {
            $offLoadingId = $request->query('offLoadingId');
            if (!$offLoading=OrderOffLoading::find($offLoadingId)) {
                return  Helper::createAPIResponce(true,400,'Invalid offloading id',[]);
            }

            $res = $this->offloaing->changeOffLoadingStatus($offLoadingId, 14);

            $orderId=$offLoading->order_id;
            $statusId=10;

            $order =$this->appointment->changeOrderStatus($orderId,$statusId);


            $this->appointment->sendNotification($orderId,$offLoading->order->customer_id,$statusId,1);
            $this->appointment->sendNotification($orderId,$offLoading->order->customer_id,$statusId,2);
            Helper::notificationTriggerHelper(1,null);
            Helper::notificationTriggerHelper(2,$offLoading->order->customer_id);


            return  Helper::createAPIResponce(false,200,'status changed',$res->get('data'));
         } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
            }
    }

    public function updateOffLoadingPackagingList(Request $request)
    {
        try {
            if (!PackgingList::find($request->id)) {
                return  Helper::createAPIResponce(true,400,'Invalid Packaging List id',[]);
            }
            $roleUpdateOrCreate = $this->packging->updatePackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

}
