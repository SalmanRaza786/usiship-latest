<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class OffLoadingController extends Controller
{
    private $offloaing;
    private $checkin;


    public function __construct(OffLoadingInterface $offloaing, CheckinInterface $checkin) {
         $this->offloaing = $offloaing;
         $this->checkin = $checkin;
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
         $request->all();
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
            if($res->get('data') != null)
            {
                $data=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxErrorWithData($res->get('message'), $res->get('data'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
