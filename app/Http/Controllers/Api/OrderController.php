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

            $validator = Validator::make($request->all(), [
                'wh_id' =>'required',
                'dock_id' => 'required',
                'opra_id' => 'required',
                'customer_id' => 'required',
                'order_status' => 'required',
                'load_type_id' => 'required',
                'order_date' => 'required',
            ]);


            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $roleUpdateOrCreate = $this->order->updateOrCreate($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                $orderData=$roleUpdateOrCreate->get('data');
                Helper::notificationTriggerHelper(1,null);
                Helper::notificationTriggerHelper(2,$orderData->customer_id);
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }

    }
    public function uploadFile(Request $request){
        try {
            $roleUpdateOrCreate = $this->order->fileUpload($request);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function getOrderDetail(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails())
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());

            $id=$request->order_id;
            if(!Order::find($id)){
                return  Helper::createAPIResponce(true,400,'invalid order id',[]);
            }


            $res=Helper::fetchOnlyData($this->order->getOrderDetail($id));

            $data = array(
                'id' =>$res->id,
                'customer_name' =>$res->customer->name,
                'order_date' => date('d M,Y',strtotime($res->order_date)) ,
                'slot' => date('i',strtotime($res->operationalHour->working_hour)),

                'dock' =>$res->dock->dock->title,
                'status_id' =>$res->status_id,
                'status_order_by' =>$res->status->order_by,
                'status' =>$res->status->status_title,
                'status_class' =>$res->status->class_name,
                'loadType' =>($res->dock->loadType)?$res->dock->loadType->direction->value .'('.$res->dock->loadType->operation->value .' ,'. $res->dock->loadType->eqType->value.' ,'. $res->dock->loadType->transMode->value.')':'-',
                'media'=>$res->fileContents,
                'orderLogs'=>$res->orderLogs,
                'wareHouse'=>$res->warehouse->title,
            );
            return  Helper::createAPIResponce(false,200,'Order detail',$data);
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function getOrdersList(Request $request)
    {
        try {
           return $res= $this->order->getAllOrdersAPI($request->user_type);
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
            return  Helper::createAPIResponce(false,200,'Order list',$data);

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(false,400,$e->getMessage(),[]);

        }
    }

    public function getAllStatus()
    {
        try {
            $data=Helper::fetchOnlyData($this->order->getAllStatus());
            return  Helper::createAPIResponce(false,200,'All Status',$data);

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(false,400,$e->getMessage(),[]);

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
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());


            $id=$request->order_id;
            if(!Order::find($id)){
                return  Helper::createAPIResponce(true,400,'invalid order id',[]);
            }

            $res= $this->order->editAppointment($id);
            if($res->get('data')){
                $data['load']=$res->get('data');
                return  Helper::createAPIResponce(false,200,$res->get('message'),$data);
            }else{
                return  Helper::createAPIResponce(true,400,'Record not found',[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }


    //updateOrderForm
    public function updateOrderForm(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
                'customfield.*' => 'required',

            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $roleUpdateOrCreate = $this->order->update($request,$request->order_id);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(false,400,$roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(false,400,$e->getMessage(),[]);
        }

    }

    public function editSchedule(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $id=$request->order_id;
            if(!Order::find($id)){
                return  Helper::createAPIResponce(true,400,'invalid order id',[]);
            }
             $allow= $this->order->isAllowToModifyOrder($id);

            if ($allow==1) {
                $res= $this->order->editAppointmentScheduling($id);
                if($res->get('data')){
                        $data['order']=$res->get('data');
                    $request = $res->get('data');
                       $wh= $this->wh->getWareHousesWithOperationHour($request);
                    $data['warehouse']=$wh->get('data');
                    return  Helper::createAPIResponce(false,200,$res->get('message'),$data);
                }else{
                    return  Helper::createAPIResponce(true,400,'Record not found',[]);
                }
            }else
            {
                return  Helper::createAPIResponce(true,400,'Not Allow To Modify Please Contact Your System Administrator',[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function updateScheduleForm(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
                'order_date' =>'required',
                'opra_id' =>'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $roleUpdateOrCreate = $this->order->updateScheduling($request,$request->order_id);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function cancelOrder(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'order_id' =>'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(!Order::find($request->order_id)){
                return  Helper::createAPIResponce(true,400,'invalid order id',[]);
            }

              $allow= $this->order->isAllowToModifyOrder($request->order_id);
            if ($allow==1) {
                $res = $this->order->cancelAppointment($request->order_id);
                return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
            }else
            {
                return  Helper::createAPIResponce(true,400,'Not Allow To Modify Please Contact Your System Administrator',[]);
            }

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }

    public function importPackagingList(Request $request){
        try {

            $id=$request->id;
            if(!Order::find($id)){
                return  Helper::createAPIResponce(true,400,'invalid order id',[]);
            }
            $roleUpdateOrCreate = $this->order->uploadPackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                $order = $this->order->changeOrderStatus($request->id,11);
                if($order->get('status')){
                    $data=$order->get('data');
                    $notification= $this->order->sendNotification($data->id,$data->customer_id,11,1);
                    if($notification->get('status')){
                        Helper::notificationTriggerHelper(1,0);

                    }
                }

                return  Helper::createAPIResponce(false,200,$roleUpdateOrCreate->get('message'),$roleUpdateOrCreate->get('data'));
            }else{
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

}
