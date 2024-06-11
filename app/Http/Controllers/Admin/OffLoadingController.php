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


    public function __construct(OffLoadingInterface $offLoading, CheckinInterface $checkin) {
         $this->offLoading = $offLoading;
         $this->checkin = $checkin;
    }

    public function index(){
        try {
            return view('admin.offloading.index');
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
            $res=$this->offLoading->getOffLoadingList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function save()
    {

    }

    public function offLoadingCreateOrUpdate(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->offLoading->offLoadingSave($request,$request->order_contact_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
