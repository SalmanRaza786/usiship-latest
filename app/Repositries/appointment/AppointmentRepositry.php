<?php
namespace App\Repositries\appointment;

use App\Events\SendEmailEvent;
use App\Http\Helpers\Helper;

use App\Imports\ImportPackagingList;
use App\Models\Admin;
use App\Models\DocksLoadType;
use App\Models\FileContent;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\OperationalHour;
use App\Models\Order;
use App\Models\OrderBookedSlot;
use App\Models\OrderForm;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\PackgingList;
use App\Models\User;
use App\Models\WareHouse;
use App\Notifications\OrderNotification;
use App\Repositries\dock\DockRepositry;
use App\Traits\HandleFiles;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;


class AppointmentRepositry implements AppointmentInterface {
    protected $orderFilePath = 'order-media/';
    protected $packgingImageFilePath = 'packaging-images/';
    protected $packgingListFilePath = 'packaging-list/';
    protected $orderFileName = "";
    protected $packagingImageFileName = "";
    protected $packagingListFileName = "";

    use HandleFiles;
    public function getAppointmentList($request)
    {

        try {
            $data['totalRecords'] = Order::count();
            $qry = Order::with('warehouse','dock.dock','operationalHour','status');
            $qry=$qry->where('customer_id',Auth::id());

            $qry = $qry->when($request->s_name, function ($query, $name) {
                return $query->whereHas('warehouse', function ($q) use ($name) {
                    $q->where('title', 'LIKE', "%{$name}%");
                });
            });

            $qry=$qry->when($request->status, function ($query, $status) {
                return $query->where('status_id',$status);
            });

            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_name')) ) {
                $data['totalRecords']=$qry->count();
            }
            return Helper::success($data, $message=__('translation.record_found'));



        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function updateOrCreate($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'wh_id' =>'required',
                'dock_id' => 'required',
                'opra_id' => 'required',
                'customer_id' => 'required',
                'order_status' => 'required',
                'load_type_id' => 'required',
                'order_date' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $order = Order::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'customer_id' =>$request->customer_id,
                    'wh_id' => $request->wh_id,
                    'dock_id' => $request->dock_id,
                    'load_type_id' => $request->load_type_id,
                    'operational_hour_id' => $request->opra_id,
                    'order_type' => 1,
                    'status_id' =>$request->order_status,
                    'order_date' => $request->order_date,
                    'created_by' => $request->created_by,
                    'guard' => $request->guard,
                ]
            );

            $orderId=$order->id;
            if($request->customfield){
                $this->saveFormFields($request,$orderId);
            }

            $logData=array(
                'orderId' => $orderId,
                'statusId' =>$request->order_status,
                'createdBy' => $request->created_by,
                'guard' =>$request->guard,
            );


            //Create booked time slots
            $this->createBookedSlots($orderId);

            //create order log
            $this->createOrderLog($logData);

            //1 for admin 2 for user
            $this->sendNotification($orderId,$request->customer_id,$request->order_status,1);
            $this->sendNotification($orderId,$request->customer_id,$request->order_status,2);


            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();
            return Helper::success($order,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function updateOrCreatePackagingInfo($request,$id)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'id' => 'required|array',
                'receiveQty' => 'required|array',
                'hi' => 'required|array',
                'ti' => 'required|array',
                'remarks' => 'required|array',
                'id.*' => 'required|integer|exists:packging_lists,id',
                'receiveQty.*' => 'required|integer',
                'hi.*' => 'required|string',
                'ti.*' => 'required|string',
                'remarks.*' => 'required|string'
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $ids = $request->id;
            $receiveQtys = $request->receiveQty;
            $Hi = $request->hi;
            $Ti = $request->ti;
            $remarks = $request->remarks;

            foreach ($ids as $index => $id) {
                $packaging = PackgingList::find($id);
                if ($packaging) {
                    $packaging->recv_qty = $receiveQtys[$index];
                    $packaging->hi = $Hi[$index];
                    $packaging->ti = $Ti[$index];
                    $packaging->remarks = $remarks[$index];
                    $packaging->save();
                }
            }

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();
            return Helper::success($packaging,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function savePackagingImages($request)
    {

        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

                $files = $request->file('file');
                $id = $request->input('packging_id');
            if ($files) {
                    $this->packagingImageFileName = $this->handleFiles($files, $this->packgingImageFilePath);
                $media = $this->mediaUpload($this->packagingImageFileName,'Image',$id,'App\Models\PackgingList');
            }
            $message = __('translation.record_created');
            DB::commit();
           // return response()->json(['success' => $media]);
            return Helper::success($media,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return response()->json(['error' => $validationException->errors()->first()], 400);
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function fileUpload($request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'file' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $files = $request->file('file');

            if ($files) {
                $this->packagingImageFileName = $this->handleFiles($files, $this->packgingImageFilePath);
                $media = $this->mediaUpload($this->packagingImageFileName,'Image',1,'App\Models\Test');

            }
            $message = __('translation.record_created');
            DB::commit();
            return Helper::success($media,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function update($request,$id)
    {
        try {
            DB::beginTransaction();
            $orderId=$request->order_id;
            if($request->customfield){
                $this->saveFormFields($request,$orderId);
            }
            ($orderId==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();
            return Helper::success($orderId,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function uploadPackagingList($request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'id' =>'required',
                'import_file' => 'required|mimes:xlsx,xls',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $file = $request->file('import_file');
            $id = $request->input('id');
            if ($file) {
                $import = new ImportPackagingList($id);
                Excel::import($import, $file);

                $this->packagingListFileName = $this->handleFiles($file, $this->packgingListFilePath);
                $this->mediaUpload($this->packagingListFileName,'Excel',$id,'App\Models\Order');

            }
            $message ="Packaging List Uploaded";
            DB::commit();
            return Helper::success(1,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function updateScheduling($request,$id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            $order->order_date = $request->order_date;
            $order->operational_hour_id = $request->opra_id;
            $order->save();

            Helper::deleteBookedSlotsAccordingOrders($order->id);
            $this->createBookedSlots($order->id);


            //1 for admin 2 for user
            $this->sendNotification($id,$order->customer_id,15,1);
            $this->sendNotification($id,$order->customer_id,15,2);


            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();
            return Helper::success($order,$message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteAppointment($id)
    {
        try {
            $role = User::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editAppointment($id)
    {
        try {
            $res = Order::with('orderForm.customFields','orderForm.files.formData.customFields')->findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }
    public function editAppointmentScheduling($id)
    {
        try {
            $res = Order::with('operationalHour')->findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }
    public function getAllOrders()
    {
        try {
            $qry= Order::query();
            $qry= $qry->with('customer','bookedSlots.operationalHour','dock.loadType.direction','orderLogs.orderStatus','warehouse:id,title','operationalHour','status');
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getOrderDetail($id)
    {
        try {

            $qry= Order::query();
            $qry= $qry->with('customer','bookedSlots.operationalHour','dock.loadType','fileContents','orderLogs.orderStatus','warehouse.assignedFields.customFields','orderForm.customFields','packgingList.inventory','warehouse:id,title','operationalHour','orderContacts.carrier.company','orderContacts.filemedia','orderContacts.carrier.docimages');
            $data =$qry->find($id);
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function getPackagingListByOrderId($id)
    {
        try {
            $qry= PackgingList::query();
            $qry= $qry->with('inventory');
            $data =$qry->where('order_id',$id)->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function saveFormFields($request,$orderId)
    {
        try {
            $customFields = $request->customfield;

            foreach ($customFields as $key => $value) {
                $file = $request->file("customfield.$key");
                $isFileField=2;

                if ($file) {
                    $isFileField=1;
                    $this->orderFileName = $this->handleFiles($file, $this->orderFilePath);
                };

                $orderForm = OrderForm::updateOrCreate(
                    [
                        'order_id' => $orderId,
                        'field_id' => $key,
                    ],
                    [
                        'order_id' => $orderId,
                        'field_id' => $key,
                        'form_value' =>($isFileField==2)?$value:$this->orderFileName,
                        'is_file' => $isFileField,
                    ]
                );
                if ($isFileField==1) {
                    $this->mediaUpload($this->orderFileName,'Image',$orderId,'App\Models\Order', $orderForm->id);
                }

            }
        } catch (\Exception $e) {
           throw $e;
        }

    }
    public function createOrderLog($logData)
    {
        try {
                $log = OrderLog::updateOrCreate(
                    [
                        'id' => 0,
                    ],
                    [
                        'order_id' => $logData['orderId'],
                        'status_id' => $logData['statusId'],
                        'created_by' => $logData['createdBy'],
                        'guard' => $logData['guard'],
                    ]
                );

        } catch (\Exception $e) {
            throw $e;
        }

    }
    public function cancelAppointment($id)
    {
        try {
            $orderStatus=$this->changeOrderStatus($id,7);
            return Helper::success($orderStatus, $message = 'Order canceled successfully');
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getAllStatus()
    {
        try {
            $qry= OrderStatus::query();
            $qry =$qry->where('order_by','<',100);
            $data =$qry->get();
            return Helper::success($data, $message="Status found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }

    }



    public function changeOrderStatus($orderId,$orderStatus)
    {
        try {

            $order= Order::find($orderId);
            $order->status_id=$orderStatus;
            $order->save();

            $logData=array(
                'orderId' => $orderId,
                'statusId' =>$orderStatus,
                'createdBy' =>Auth::id(),
                'guard' =>'admin',
            );

            //create order log
            $this->bookedSlotsMakedFree($orderId,$orderStatus);
            $this->createOrderLog($logData);
            if($orderStatus==1 AND OrderBookedSlot::where('order_id',$orderId)->count()==0){
                $this->createBookedSlots($orderId);
            }



         return Helper::success($order,'Status updated');

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }


    }

    public function bookedSlotsMakedFree($orderId,$orderStatus)
    {
        try {

            if($status=OrderStatus::find($orderStatus)){
                if($status->order_by < 10){
                    OrderBookedSlot::where('order_id',$orderId)->delete();
                }
            }
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }


    }

    public function createBookedSlots($orderId)
    {
        try {

            $order=Order::find($orderId);
            $dockId=$order->dock_id;
            $loadTypeId=$order->load_type_id;
            $operationalHourId=$order->operational_hour_id;


            $dockInfo= Helper::getDockInfo($dockId,$loadTypeId);
            $timeSlices=$dockInfo->loadType->duration /30;
            $operationalHour=OperationalHour::where('id','>=',$operationalHourId)->get();

            for($i=0; $i<$timeSlices; $i++){
                $orderBookedSlot= OrderBookedSlot::updateOrCreate(
                    [
                        'order_id' =>$orderId,
                        'operational_hour_id' =>$operationalHour[$i]->id,
                    ],
                    [
                        'order_id' =>$orderId,
                        'operational_hour_id' =>$operationalHour[$i]->id,
                    ]
                );
            }

            return $orderBookedSlot;

        } catch (\Exception $e) {
           throw $e;

        }


    }

    public function checkBookedSlot($allowedSlots,$operationHourId,$orderDate,$whId)
    {
        try {

            $isAllow=1;
             $countOrderBookedSlot = OrderBookedSlot::with('order.status')
                ->where('operational_hour_id', $operationHourId)

                ->whereHas('order', function($query) use($orderDate,$whId) {
                    $query->whereDate('order_date', date('Y-m-d', strtotime($orderDate)))
                        ->where('wh_id',$whId)
                        ->whereHas('status', function($statusQuery) {
                            $statusQuery->where('order_by', '>', 10);
                        });
                })
                ->count();
            if($countOrderBookedSlot >= $allowedSlots){
                $isAllow=0;
            }
            return $isAllow;



        } catch (\Exception $e) {
            throw $e;

        }


    }

    public function isAllowToModifyOrder($id)
    {
        try {

            $order = Order::with('dock.dock','operationalHour')
                ->where('id', $id)->first();
            $dateTimeString = $order->order_date . ' ' . $order->operationalHour->working_hour;
            $endDate = Carbon::parse($dateTimeString);
            $startDate = Carbon::now();
            $diffInHours = $startDate->diffInHours($endDate);

            $cancelHours= $order->dock->dock->cancel_before;
             if($diffInHours >= $cancelHours){


                 $isAllow=1;;
             }else{
                 $isAllow=0;
            }
            return $isAllow;

        } catch (\Exception $e) {
            throw $e;

        }
    }

    public function checkOrderId($request)
    {
        try {
            $orderId = $request->query('order_id');
            $res = Order::where('order_id', $orderId)->exists();
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }
    public function verifyWarehouseId($request)
    {
        try {
            $warehouseId = $request->input('warehouseId');
            $orderId = $request->input('orderId');
            $res = Order::with('operationalHour')->where('wh_id', $warehouseId)->where('id',$orderId)->first();
           if ($res)
           {
               $dateTimeString = $res->order_date . ' ' . $res->operationalHour->working_hour;
               $dateTime = Carbon::parse($dateTimeString);
               $now = Carbon::now();
               $difference = $dateTime->diffForHumans($now, ['syntax' => Carbon::DIFF_RELATIVE_TO_NOW]);
               $data = array(
                   "current_date_time" =>  $now->format('Y-m-d H:i:s'),
                   "time_difference" => $difference
               );
               return Helper::success($data, $message='Warehouse ID is valid');
           }else{
               return Helper::error("Invalid Warehouse ID!");
           }

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function undoOrderStatus($orderId)
    {
        try {


                $secondLastRecord = OrderLog::orderBy('id', 'desc')
                    ->offset(1)
                    ->limit(1)
                    ->first();

                $order=Order::find($orderId);
            $order->status_id=$secondLastRecord->status_id;
            $order->save();

            $logData=array(
                'orderId' => $orderId,
                'statusId' =>$secondLastRecord->status_id,
                'createdBy' => Auth::user()->id,
                'guard' =>'admin',
            );

            $this->createOrderLog($logData);
            return Helper::success($secondLastRecord->status_id,'Status undo success');

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }


    }

    public function mediaUpload($fileName=null,$fileType=null,$fileableId=null,$fileableType=null,$formId=null,$fieldName=null)
    {
        try {

            if($formId != null)
            {
                $data =[
                    'fileable_id' => $fileableId,
                    'form_id' => $formId,
                ];
            }else{
                $data =[
                    'fileable_id' => 0,
                ];
            }

            $media = FileContent::updateOrCreate(
                $data,
                [
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'fileable_id' => $fileableId,
                    'fileable_type' => $fileableType,
                    'form_id' => $formId,
                    'field_name' => $fieldName,
                ]);

            return $media;

        } catch (\Exception $e) {
            throw $e;


        }

    }


    public function sendNotification($orderId,$customerId,$statusId,$notificationFor)
    {
        try {

            //$userType 1 for admin and 2 for customer,3 for both
            $notifyContent = NotificationTemplate::where('status_id', $statusId)->first();
            if (!$notifyContent) {
                return Helper::error('notification not configured');
            }
            if ($notificationFor == 1 ) {
                Helper::createNotificationHelper($notifyContent, 'admin.orders.list');
            }

            if ($notificationFor == 2 ) {
                Helper::createEndUserNotificationHelper($notifyContent, 'user.appointment.show-list', $customerId, 'App\Models\User');
            }

            $this->sendNotificationViaEmail($orderId, $customerId, $statusId, $notifyContent);
            return Helper::success([],'Notification created successfully');
        }
        catch (\Exception $e) {
                throw $e;
            }

    }

    public function sendNotificationViaEmail($orderId,$customerId,$statusId,$notifyContent)
    {
        try {

            $mailData = [
                'subject' => 'Order Requested',
                'greeting' => 'Hello',
                'content' => $notifyContent->mail_content,
                'actionText' => 'View Your Order Details',
                'actionUrl' => url('/get-order-detail/' . ($orderId)),
                'orderId' => $orderId,
                'statusId' => $statusId,
            ];

            if (!$customer = User::find($customerId)) {
                return Helper::error('customer not exist');
            }
             $res=$customer->notify(new OrderNotification($mailData));
            //event(new SendEmailEvent($mailData, $customer));

            $log = NotificationLog::updateOrCreate(
                [
                    'id' => 0,
                ],
                [
                    'order_id' => $orderId,
                    'status_id' => $statusId,
                    'content' => $notifyContent->mail_content,
                    'notification_type' => 1,
                ]
            );

        } catch (\Exception $e) {
            throw $e;
        }
    }





}





