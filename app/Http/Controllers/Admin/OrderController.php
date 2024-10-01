<?php

namespace App\Http\Controllers\Admin;

use App\Events\ClientNotificationEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Notification;
use App\Models\OperationalHour;
use App\Models\Order;
use App\Models\OrderBookedSlot;
use App\Models\OrderForm;
use App\Models\OrderStatus;
use App\Notifications\OrderNotification;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\dock\DockRepositry;
use App\Repositries\loadType\loadTypeRepositry;
use App\Repositries\notification\NotificationInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $order;
    private $wh;
    private $customer;
    private $appointment;
    private $notification;

    public function __construct(AppointmentInterface $order,WhInterface $wh,CustomerInterface $customer,AppointmentInterface $appointment,NotificationInterface $notification){
        $this->order = $order;
        $this->wh = $wh;
        $this->customer =$customer;
        $this->appointment =$appointment;
        $this->notification =$notification;
    }
    public function index()
    {
        try {
            $data['wareHouse']=Helper::fetchOnlyData($this->wh->getAllWhList());
            $data['customers']=Helper::fetchOnlyData($this->customer->getAllCustomers());
            $data['status']=Helper::fetchOnlyData($this->order->getAllStatus());
            return view('admin.order.orders-list')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getOrders()
    {
       try {
        $res = $this->order->getAllOrders();
        $data = collect([]);
        foreach ($res['data'] as $row) {

            $fromOperationalHour = $row->bookedSlots->first();
            $toOperationalHour = $row->bookedSlots->last();


            $array = array(
                'id' => $row->id,
                'wh_name' => $row->warehouse->title,
                'customer_name' => $row->customer->name,
                'start_time_hour' => count($row->bookedSlots) ? date('H', strtotime($fromOperationalHour->operationalHour->working_hour)) : date('H', strtotime($row->operationalHour->working_hour)),
                'end_time_minut' => count($row->bookedSlots) ? date('i', strtotime($fromOperationalHour->operationalHour->working_hour)) : date('i', strtotime($row->operationalHour->working_hour)),
                'end_s' => count($row->bookedSlots) ? date('H', strtotime($toOperationalHour->operationalHour->working_hour)) : date('H', strtotime($row->operationalHour->working_hour)),
                'end_e' => count($row->bookedSlots) ? date('i', strtotime($toOperationalHour->operationalHour->working_hour)) : date('i', strtotime($row->operationalHour->working_hour)),
                'order_date' => date('d', strtotime($row->order_date)),
                'order_month' => date('m', strtotime($row->order_date)),
                'order_year' => date('Y', strtotime($row->order_date)),
                'active_class' => $row->status->class_name,
                'status' => $row->status->status_title,

            );
            $data->push($array);
            }
    return Helper::success($data,'Order list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }


    //getOrderDetail
    public function getOrderDetail($id)
    {
        try {
            if (!Order::find($id)) {
                return back()->with('error','Invalid order id');
            }
            $data['orderDetail']=$this->getOrderInfo($id);
            return view('admin.order.order-detail')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAppointmentDetail($id)
    {
        try {
            $data['orderDetail']=$this->getOrderInfo($id);
            return view('client.screens.appointment.order-detail')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //getOrderInfo
    public function getOrderInfo($id)
    {
        try {


             $res=Helper::fetchOnlyData($this->order->getOrderDetail($id));

            $fromOperationalHour=$res->bookedSlots->first();
            $toOperationalHour=$res->bookedSlots->last();

            $guards = array_keys(config('auth.guards'));
            $currentGuard = null;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $currentGuard = $guard;
                    break;
                }
            }
            if($currentGuard !='web'){
                $allow = 1;
            }else{
                $allow= $this->appointment->isAllowToModifyOrder($id);
            }


            $data = array(
                'id' =>$res->id,
                'order_id' =>$res->order_id,
                'isAllowEdit' =>$allow,
                'guard' =>$currentGuard,
                'ware_house' =>$res->warehouse->title,
                'email' =>$res->warehouse->email,
                'phone' =>$res->warehouse->phone,
                'customer_name' =>$res->customer->name,
                'customer_email' =>$res->customer->email,
                'order_date' => date('d M,Y',strtotime($res->order_date)) ,
                'slot_from' =>count($res->bookedSlots)? $fromOperationalHour->operationalHour->working_hour:$res->operationalHour->working_hour,
                'slot_to' => count($res->bookedSlots)? $toOperationalHour->operationalHour->working_hour:$res->operationalHour->working_hour,
                'dock' =>$res->dock->title,
                'status' =>$res->status->status_title,
                'status_id' =>$res->status_id,
                'status_class' =>$res->status->class_name,
                'status_order_by' =>$res->status->order_by,
                'text_class' =>$res->status->text_class,
                'loadType' =>($res->dock->loadType)?$res->dock->loadType->direction->value .'('.$res->dock->loadType->operation->value .' ,'. $res->dock->loadType->eqType->value.' ,'. $res->dock->loadType->transMode->value.')':'-',
                'media'=>$res->fileContents,
                'orderLogs'=>$res->orderLogs,
                'warehouse'=>$res->warehouse,
                'orderForm'=>$res->orderForm,
                'packagingList'=>$res->packgingList ?? [],
                'orderContacts'=>$res->orderContacts ?? [],
                'itemPutAway'=>$res->itemPutAway ?? [],
            );
            return Helper::success($data,'Order Info');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createNewOrder(Request $request)
    {
        try {
            $data['customerId']=$request->customer_id;
            $data['status']=OrderStatus::get();
            $data['selectStatus']=$request->order_status;
            $data['createdBy']=Auth::id();
            $data['guard']='admin';
            return view('admin.order.create')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //storeOrder
    public function  storeOrder(Request $request)
    {
        try {
            $dock=new DockRepositry();
            $dockInfo=Helper::fetchOnlyData($dock->editDock($request->dock_id));
           if($isAllow=$this->appointment->checkBookedSlot($dockInfo->slot,$request->opra_id,$request->order_date,$request->wh_id)==0){
               return Helper::error('all slots are booked of this dock',[]);
           }

             $roleUpdateOrCreate = $this->appointment->updateOrCreate($request,0);
           if ($roleUpdateOrCreate->get('status')){
               $orderData=$roleUpdateOrCreate->get('data');
               // 1 use for admin 2 for user
               $this->notificationTrigger(1,null);
               $this->notificationTrigger(2,$orderData->customer_id);
               return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
           }else{
               return Helper::error($roleUpdateOrCreate->get('message'),[]);
           }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function savePackagingInfo(Request $request)
    {
        try {

            $roleUpdateOrCreate = $this->appointment->updateOrCreatePackagingInfo($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function savePackagingImages(Request $request)
    {

        try {

            $roleUpdateOrCreate = $this->appointment->savePackagingImages($request);
            if ($roleUpdateOrCreate->get('status')){
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::error($roleUpdateOrCreate->get('message'),[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }


    //changeOrderStatus
    public function changeOrderStatus($orderId,$orderStatus)
    {
        try {
            $order = $this->appointment->changeOrderStatus($orderId,$orderStatus);
             if($order->get('status')){
                 $data=$order->get('data');
                 $customerId=$data->customer_id;
                $notification= $this->appointment->sendNotification($orderId,$customerId,$orderStatus,2);

                if($notification->get('status')){
                    $this->notificationTrigger(2,$customerId);
                }
             }
             return $order;
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }


    public function checkOrderId(Request $request)
    {
        try {
            $res= $this->appointment->checkOrderId($request);
            return Helper::ajaxSuccess($res,'Order ID validation');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function verifyWarehouseId(Request $request)
    {
        try {
                $res= $this->appointment->verifyWarehouseId($request);
            if ($res->get('status'))
                return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
            return Helper::ajaxErrorWithData($res->get('message'), $res->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public  function undoOrderStatus($orderId)
    {
        try {
            $res= $this->appointment->undoOrderStatus($orderId);
            if ($res->get('status')){
                return Helper::success($res->get('data'),$res->get('message'));
            }else{
                return Helper::error($res->get('message'),[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function notificationTrigger($type,$totifiableId)
    {
        try {

          $res=Helper::notificationTriggerHelper($type,$totifiableId);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function transactionIndex()
    {
        try {

            return view('admin.transactions.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function transactionsList(Request $request){
        try {
            $res=$this->appointment->getTransactionsList($request);

            $transactionData = collect([]);

           foreach ($res['data']['data'] as $row) {

               $array = array(
                   'id' => $row->id,
                   'enc_id' => encrypt($row->id),
                   'order_id' => $row->order_id,
                   'order_type' => ($row->order_type == 1 ? "Inbound":"Outbound"),
                   'customer_name' => $row->customer->name,
                   'warehouse_title' =>$row->warehouse->title,
                   'dock_title' =>$row->dock->dock->title,
                   'order_date' => $row->order_date,
                   'operational_hour_working_hour' => $row->operationalHour->working_hour,
                   'status_title' => $row->status->status_title,
               );
               $transactionData->push($array);
           }

            return Helper::ajaxDatatable($transactionData, $res['data']['totalRecords'], $request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }


}
