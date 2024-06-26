<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class CheckInController extends Controller
{

    private $checkin;
    private $orderContact;

    public function __construct(CheckInInterface $checkin, OrderContactInterface $orderContact) {
        $this->checkin = $checkin;
        $this->orderContact = $orderContact;
    }
    public function index(){
        try {
            return view('admin.checkin.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function checkInList(Request $request){
        try {
            $res=$this->checkin->getCheckinList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function checkinCreateOrUpdate(Request $request)
    {
        try {
          $roleUpdateOrCreate = $this->checkin->checkinSave($request,$request->order_contact_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public  function findCheckIn($checkinId)
    {
        try {
            $res= $this->checkin->findCheckIn($checkinId);
            if ($res->get('status')){
                return Helper::success($res->get('data'),$res->get('message'));
            }else{
                return Helper::error($res->get('message'),[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
