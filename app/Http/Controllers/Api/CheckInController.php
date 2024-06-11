<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
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
