<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class OrderContactController extends Controller
{
    private $orderContact;

    public function __construct(OrderContactInterface $orderContact)
    {
        $this->orderContact = $orderContact;
    }

    public function orderContactList(Request $request){
        try {
            $res=$this->orderContact->getOrderContactList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function updateOrderContact(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->orderContact->updateOrderContact($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function getOrderContactList()
    {
        try {
            $res = $this->orderContact->getAllOrderContactList();
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
    public function getOrderContact(Request $request)
    {
        try {
            $res = $this->orderContact->getOrderContact($request->id);
            if ($res->get('status'))
            {
                return Helper::success($res->get('data'),$res->get('message'));
            }else{
                return Helper::error("Data not found");
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
