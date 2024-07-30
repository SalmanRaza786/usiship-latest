<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\WorkOrder;
use App\Repositries\orderStatus\OrderStatusInterface;
use App\Repositries\user\UserInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    private $workOrder;
    private $staff;
    private $status;


    public function __construct(WorkOrderInterface $workOrder,UserInterface $staff,OrderStatusInterface $status) {
        $this->workOrder =$workOrder;
        $this->staff =$staff;
        $this->status =$status;

    }

    public function workOrders()
    {
        try {
            $data['staff']=Helper::fetchOnlyData($this->staff->getAllUser());
            $data['status']=Helper::fetchOnlyData($this->status->getAllStatus());
            return view('admin.outbounds.work-orders.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }

    public function workOrdersList(Request $request)
    {

        try {
              $res=$this->workOrder->getWorkOrderList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //pickerAssign
    public function pickerAssign(Request $request)
    {

        try {
             $request->all();
            if(!$workOrder=WorkOrder::find($request->w_order_id)){
                return Helper::error('Invalid Order Id');
            }
             $res=$this->workOrder->savePickerAssign($request);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            }else{
                return Helper::ajaxError($res->get('message'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
