<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\WorkOrder;
use App\Repositries\orderStatus\OrderStatusInterface;
use App\Repositries\user\UserInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    //getAllStaff
    public function getAllStaff()
    {
        try {
             $res=$this->staff->getAllUser();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
            }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function getAllStatus()
    {
        try {
            $res=$this->status->getAllStatus();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function workOrdersList(Request $request)
    {
        try {
            $res=$this->workOrder->getAllWorkOrderList();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    //pickerAssign
    public function pickerAssign(Request $request)
    {

        try {

            $request->all();

            $validator = Validator::make($request->all(), [
                'w_order_id' =>'required',
                'staff_id' =>'required',
                'status_code' =>'required',
                'auth_id' =>'required',
            ]);

            if ($validator->fails())
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());

            if(!$workOrder=WorkOrder::find($request->w_order_id)){
                return  Helper::createAPIResponce(true,400,'Invalid Order Id',[]);

            }
            $res=$this->workOrder->savePickerAssign($request);
            if ($res->get('status')) {
                return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$res->get('message'),[]);

            }

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }
}
