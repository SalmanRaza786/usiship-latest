<?php

namespace App\Repositries\workOrder;

use App\Http\Helpers\Helper;
use App\Models\PickedItem;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Facades\Auth;
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
                    'status_code' => $request->status_code,
                    'auth_id' =>Auth::user()->id,
                ]
            );


            $items=WorkOrderItem::where('work_order_id',$request->w_order_id)->get();
            if($items->count() > 0){
                foreach ($items as $row){

                    $pickedItems= PickedItem::updateOrCreate(
                        [
                            'id' =>0,
                        ],
                        [
                            'picker_table_id' =>$workOrderPicker->id,
                            'w_order_item_id' =>$row->id,
                            'inventory_id' =>$row->inventory_id,
                            'loc_id' =>$row->loc_id,
                            'order_qty' =>$row->qty,
                        ]
                    );
                }
            }

            $workOrder=WorkOrder::find($request->w_order_id);
            $workOrder->status_code=202;
            $workOrder->save();


            DB::commit();
            return Helper::success($workOrderPicker,'Job assigned successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
