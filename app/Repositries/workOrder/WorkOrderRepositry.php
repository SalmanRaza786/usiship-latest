<?php

namespace App\Repositries\workOrder;

use App\Http\Helpers\Helper;
use App\Models\WorkOrder;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Facades\DB;


class WorkOrderRepositry implements WorkOrderInterface
{



    public function getWorkOrderList($request)
    {
        try {
            $data['totalRecords'] = WorkOrder::count();
            $qry= WorkOrder::query();
            $qry= $qry->with('client:id,name','status:id,status_title,order_by');
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function savePickerAssign($request)
    {
        try {

            DB::beginTransaction();
            $workOrderPicker= WorkOrderPicker::updateOrCreate(
                [
                    'work_order_id' =>$request->w_order_id,
                ],
                [
                    'work_order_id' => $request->w_order_id,
                    'picker_id' => $request->staff_id,
                    'status_code' => $request->status_code
                ]
            );

            $workOrder=WorkOrder::find($request->w_order_id);
            $workOrder->status_code=202;
            $workOrder->save();

            DB::commit();
            return Helper::success($workOrderPicker,'Record created');

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
