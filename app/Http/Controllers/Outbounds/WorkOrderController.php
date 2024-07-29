<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\user\UserInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    private $workOrder;
    private $staff;


    public function __construct(WorkOrderInterface $workOrder,UserInterface $staff) {
        $this->workOrder =$workOrder;
        $this->staff =$staff;

    }

    public function workOrders()
    {
        try {
            $data['staff']=Helper::fetchOnlyData($this->staff->getAllUser());
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
            return $request->all();

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
