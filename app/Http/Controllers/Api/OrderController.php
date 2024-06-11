<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Order;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\loadType\loadTypeInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $order;
    private $wh;
    private $checkIn;

    public function __construct(AppointmentInterface $order ,WhInterface $wh,CheckInInterface $checkIn) {
        $this->order = $order;
        $this->wh = $wh;
        $this->checkIn = $checkIn;

    }
    public function saveOrders(Request $request){
        try {
              $request->all();
            $roleUpdateOrCreate = $this->order->updateOrCreate($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function uploadFile(Request $request){
        try {
            $roleUpdateOrCreate = $this->order->fileUpload($request);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getOrderDetail(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $id=$request->order_id;
            if(!Order::find($id)){
                return Helper::error('invalid order id',[]);
            }


            $res=Helper::fetchOnlyData($this->order->getOrderDetail($id));
            $data = array(
                'id' =>$res->id,
                'customer_name' =>$res->customer->name,
                'order_date' => date('d M,Y',strtotime($res->order_date)) ,
                'slot' => date('i',strtotime($res->operationalHour->working_hour)),
                'dock' =>$res->dock->title,
                'status' =>$res->status->status_title,
                'status_class' =>$res->status->class_name,
                'loadType' =>($res->dock->loadType)?$res->dock->loadType->direction->value .'('.$res->dock->loadType->operation->value .' ,'. $res->dock->loadType->eqType->value.' ,'. $res->dock->loadType->transMode->value.')':'-',
                'media'=>$res->fileContents,
                'orderLogs'=>$res->orderLogs,
                'wareHouse'=>$res->warehouse->title,
            );


            return Helper::success($data,'Order list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getOrdersList()
    {
        try {
           return $res= $this->order->getAllOrders();
            $data = collect([]);
            foreach ($res['data'] as $row){

                $array = array(
                    'id' =>$row->id,
                    'customer_name' =>$row->customer->name,
                    'order_id' =>$row->order_id,
                    'start_time_hour' => date('H',strtotime($row->operationalHour->working_hour)),
                    'end_time_minut' => date('i',strtotime($row->operationalHour->working_hour)),
                    'order_date' => date('d',strtotime($row->order_date)) ,
                    'order_month' => date('m',strtotime($row->order_date)),
                    'order_year' => date('Y',strtotime($row->order_date)),
                    'load_type' => $row->dock->loadType->direction->value,
                    'status'=>($row->orderLogs)?$row->orderLogs:[]
                );
                $data->push($array);
            }
            return Helper::success($data,'Order list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllStatus()
    {
        try {
            $data=Helper::fetchOnlyData($this->order->getAllStatus());
            return Helper::success($data,'All Status');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //editOrderForm
    public function  editOrderForm(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $id=$request->order_id;
            if(!Order::find($id)){
                return Helper::error('invalid order id',[]);
            }

            $res= $this->order->editAppointment($id);
            if($res->get('data')){
                $data['load']=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }


    //updateOrderForm
    public function updateOrderForm(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'customfield' =>'required',
                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());
            $roleUpdateOrCreate = $this->order->update($request,$request->order_id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function editSchedule(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $id=$request->order_id;
            if(!Order::find($id)){
                return Helper::error('invalid order id',[]);
            }
             $allow= $this->order->isAllowToModifyOrder($id);

            if ($allow==1) {
                $res= $this->order->editAppointmentScheduling($id);
                if($res->get('data')){
                        $data['order']=$res->get('data');
                    $request = $res->get('data');
                       $wh= $this->wh->getWareHousesWithOperationHour($request);
                    $data['warehouse']=$wh->get('data');
                    return Helper::ajaxSuccess($data,$res->get('message'));
                }else{
                    return Helper::ajaxError('Record not found');
                }
            }else
            {
                return Helper::error('Not Allow To Modify Please Contact Your System Administrator');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function updateScheduleForm(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
                'order_date' =>'required',
                'opra_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $roleUpdateOrCreate = $this->order->updateScheduling($request,$request->order_id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function cancelOrder(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [

                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());
              $allow= $this->order->isAllowToModifyOrder($request->order_id);
            if ($allow==1) {
                $res = $this->order->cancelAppointment($request->order_id);
                return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
            }else
            {
                return Helper::error('Not Allow To Modify Please Contact Your System Administrator');
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function importPackagingList(Request $request){
        try {

            $id=$request->id;
            if(!Order::find($id)){
                return Helper::error('invalid order id',[]);
            }
            $roleUpdateOrCreate = $this->order->uploadPackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function getOrderCheckIList()
    {
        try {
            $res = $this->checkIn->getOrderCheckinList();
            if ($res->get('status'))
            {
                return Helper::success($res->get('data'),'Order Contact list');
            }else{
                return Helper::error("Data not found");
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
