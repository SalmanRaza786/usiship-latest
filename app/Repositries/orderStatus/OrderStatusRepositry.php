<?php

namespace App\Repositries\orderStatus;

use App\Http\Helpers\Helper;
use App\Models\OrderStatus;
use App\Models\WorkOrder;



class OrderStatusRepositry implements OrderStatusInterface
{

    public function getAllStatus()
    {
        try {
            $qry= OrderStatus::query();
            $data =$qry->get();
            return Helper::success($data, $message="Status found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }

    }
}
