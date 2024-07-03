<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderCheckIn;
use App\Models\OrderOffLoading;
use App\Models\PackgingList;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\packagingList\PackagingListRepositry;
use Illuminate\Http\Request;

class OffLoadingController extends Controller
{
    private $offloaing;
    private $checkin;
    private $packging;


    public function __construct(OffLoadingInterface $offloaing, CheckinInterface $checkin,PackagingListRepositry $packging ) {
        $this->offloaing = $offloaing;
        $this->checkin = $checkin;
        $this->packging = $packging;
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
            return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
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
            return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
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
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }
        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function saveOffLoadingImages(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offloaing->offLoadingImagesSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function checkOrderCheckInId(Request $request)
    {
        try {
            $res= $this->offloaing->checkOrderCheckInId($request);
            if($res->get('data') != null)
            {
                $data=$res->get('data');
                return  Helper::createAPIResponce(false,200,$res->get('message'),$data);
            }else{
                return  Helper::createAPIResponce(true,400,"Order checkin id not found",[]);
            }

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }


    public function closeItemPutAway(Request $request)
    {
        try {
            $offLoadingId = $request->query('offLoadingId');
            if (!OrderOffLoading::find($offLoadingId)) {
                return  Helper::createAPIResponce(true,400,'Invalid offloading id',[]);
            }
            $res = $this->offloaing->changeOffLoadingStatus($offLoadingId, 14);
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
            return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

}
