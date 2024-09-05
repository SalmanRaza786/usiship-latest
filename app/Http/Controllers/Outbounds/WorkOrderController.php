<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\WhLocation;
use App\Models\WorkOrder;
use App\Repositries\orderStatus\OrderStatusInterface;
use App\Repositries\user\UserInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class WorkOrderController extends Controller
{
    private $workOrder;
    private $staff;
    private $status;
    private $dataService;


    public function __construct(WorkOrderInterface $workOrder,UserInterface $staff,OrderStatusInterface $status,DataService $dataService) {
        $this->workOrder =$workOrder;
        $this->staff =$staff;
        $this->status =$status;
        $this->dataService =$dataService;

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

            $validator = Validator::make($request->all(), [
                'staff_id' => 'required',
            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            if(!$workOrder=WorkOrder::find($request->w_order_id)){
                return Helper::error('Invalid Order Id');
            }
             $res=$this->workOrder->savePickerAssign($request);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            }else{
                return Helper::error($res->get('message'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function fetchOrdersData()
    {
//        2024-09-05T00:00:00Z
        $Orderendpoint = 'orders?created_date[eq]=2024-09-05T05:45:53Z';

        try {
            $batchSize = 1000;
            $wmsOrders = $this->dataService->fetchAllData($Orderendpoint);
            $allData = [];
            foreach (array_chunk($wmsOrders, $batchSize) as $batch) {
                foreach ($batch as &$order) {

                    foreach ($order['line_items'] as &$item) {
                        $Inventoryendpoint = 'inventory?warehouse_customer_id=' . $order['warehouse_customer_id'] . '&sku=' . $item['sku'];
                        $inventory = $this->dataService->fetchAllData($Inventoryendpoint);

                        foreach ($inventory as &$product) {
                            $remainingQuantity = $item['quantity'];
                            $selectedLocations = [];

                            foreach ($product['locations'] as $location) {

                                if ($location['quantity'] >= $remainingQuantity) {

                                    $location['quantity'] = $remainingQuantity;
                                    $selectedLocations[] = $location;
                                    $remainingQuantity = 0;
                                    break;
                                } else {

                                    $selectedLocations[] = $location;
                                    $remainingQuantity -= $location['quantity'];
                                }
                            }


                            $product['locations'] = $selectedLocations;
                        }

                        $item['inventory'] = $inventory;
                    }
                    $allData[] = $order;
                }

            }

            $res=$this->workOrder->importWorkOrder($allData);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            }else{
                return Helper::error($res->get('message'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }





}
