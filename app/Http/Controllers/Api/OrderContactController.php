<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class OrderContactController extends Controller
{
    private $orderContact;

    public function __construct(OrderContactInterface $orderContact)
    {
        $this->orderContact = $orderContact;
    }

    public function getOrderContactList()
    {
        try {
            $res = $this->orderContact->getAllOrderContactList();
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
