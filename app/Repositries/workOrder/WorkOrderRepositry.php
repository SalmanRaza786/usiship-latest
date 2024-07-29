<?php

namespace App\Repositries\workOrder;

use App\Http\Helpers\Helper;
use App\Models\WorkOrder;



class WorkOrderRepositry implements WorkOrderInterface
{



    public function getWorkOrderList($request)
    {
        try {
            $data['totalRecords'] = WorkOrder::count();
            $qry= WorkOrder::query();
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
