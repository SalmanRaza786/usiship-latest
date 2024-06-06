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
}
