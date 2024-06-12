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

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $roleUpdateOrCreate = $this->checkin->checkinSave($request,$request->order_contact_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function getOrderCheckIList()
    {
        try {
            $res = $this->checkin->getOrderCheckinList();
            if ($res->get('status'))
            {
                return Helper::success($res->get('data'),'Order Contact list');
            }else{
                return Helper::error("Data not found");
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
