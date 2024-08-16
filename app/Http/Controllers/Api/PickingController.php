<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\WorkOrder;
use App\Models\WorkOrderPicker;
use App\Repositries\picking\PickingInterface;
use App\Repositries\wh\WhInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PickingController extends Controller
{
    private $workOrder;
    private $picking;
    private $wh;

    public function __construct(WorkOrderInterface $workOrder,PickingInterface $picking,WhInterface $wh) {
        $this->workOrder =$workOrder;
        $this->picking =$picking;
        $this->wh =$wh;
    }


    //pickerList
    public function pickerList()
    {
        try {
            $res=$this->picking->getAllPickersForApi();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);


        }
    }

    public function getAllLocations()
    {
        try {
            $res=$this->wh->getWhLocations();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
            }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
            }

    }
    public function startPicking(Request $request)
    {
        try {
            $pickerId=$request->query('pickerId');

            if(!$workOrderP=WorkOrderPicker::find($pickerId)){
                return  Helper::createAPIResponce(true,400,'Invalid Order Picker Id',[]);

            }
            $data['orderInfo']=Helper::fetchOnlyData($this->picking->getPickerInfo($pickerId));
            $data['pickingItems']=Helper::fetchOnlyData($this->picking->getPickingItems($pickerId));
            return  Helper::createAPIResponce(false,200,'Start picking now',$data);

        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    //updateStartPicking
    public function updateStartPicking(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'pickerId' =>'required',
                'updateType' =>'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(!$qry= WorkOrder::find($request->workOrderId)){
                return Helper::error('Invalid Order id');
            }

              $res=$this->picking->updateStartPicking($request);
             return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    //savePickedItems
    public function savePickedItems(Request $request)
    {

        try {
            $request->all();
            return $res=$this->picking->savePickedItems($request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
