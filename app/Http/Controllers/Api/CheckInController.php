<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckInController extends Controller
{
    private $checkin;
    private $orderContact;

    public function __construct(CheckInInterface $checkin, OrderContactInterface $orderContact) {
        $this->checkin = $checkin;
        $this->orderContact = $orderContact;
    }
    public function checkinCreateOrUpdate(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'order_contact_id' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $roleUpdateOrCreate = $this->checkin->checkinSave($request,$request->order_contact_id);
            if ($roleUpdateOrCreate->get('status'))
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function getOrderCheckIList()
    {
        try {
            $res = $this->checkin->getOrderCheckinList();
            if ($res->get('status'))
            {
                return  Helper::createAPIResponce(false,200,'Order Contact list',$res->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,"Data not found",[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
