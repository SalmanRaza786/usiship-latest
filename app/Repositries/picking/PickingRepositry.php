<?php

namespace App\Repositries\picking;

use App\Http\Helpers\Helper;
use App\Models\WorkOrder;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Facades\DB;


class PickingRepositry implements PickingInterface
{



    public function getAllPickers($request)
    {
        try {
            $data['totalRecords'] = WorkOrderPicker::count();
            $qry= WorkOrderPicker::query();
            $qry= $qry->with('workOrder.client','workOrder.carrier','workOrder.loadType.direction','workOrder.loadType.eqType','status');
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}
