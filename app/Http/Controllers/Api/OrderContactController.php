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
                return Helper::success($res->get('data'),'Order Contact list');
            }else{
                return Helper::error($res->get('message'),[]);
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
