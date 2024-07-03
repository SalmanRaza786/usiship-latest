<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderOffLoading;
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
            $roleUpdateOrCreate = $this->offloaing->offLoadingSave($request,$request->order_checkin_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function packagingListConfirmation(Request $request){

        try {
            $roleUpdateOrCreate = $this->offloaing->findOffloadingByCheckInId($request->checkin_id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
            }
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function saveOffLoadingImages(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offloaing->offLoadingImagesSave($request,$request->id);
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
            if($res->get('data') != null)
            {
                $data=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::error("Order checkin id not found");
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
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
            $roleUpdateOrCreate = $this->packging->updatePackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));


        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

}
