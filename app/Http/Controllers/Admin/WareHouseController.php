<?php

namespace App\Http\Controllers\Admin;

use App\Events\MyEvent;
use App\Events\SendEmailEvent;
use App\Events\SendNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\LoadType;
use App\Models\NotificationTemplate;
use App\Models\OperationalHour;
use App\Models\OrderBookedSlot;
use App\Models\User;
use App\Models\WhDock;
use App\Models\WhOffDay;
use App\Models\WhWorkingHour;
use App\Notifications\OrderNotification;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\dock\DockRepositry;
use App\Repositries\wh\WhInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Help;

class WareHouseController extends Controller
{
    private $wh;
    private $customField;
    private $order;

    public function __construct(WhInterface $wh, CustomFieldInterface $customField,AppointmentInterface $order)
    {
        $this->wh = $wh;
        $this->customField = $customField;
        $this->order = $order;

    }

    public function index()
    {

        try {
            return view('admin.wh.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function whList(Request $request)
    {
        try {
            $res = $this->wh->getWhList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getAllWhList(Request $request)
    {
        try {
            $res = $this->wh->getAllWhList();
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::error('data not found', []);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getGeneralOperationalHoursByWhId(Request $request)
    {
        try {
            $res = $this->wh->getWareHousesWithOperationHour($request);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::error('data not found', []);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function createWh(Request $request)
    {
        try {
            $data['ltMaterial'] = LoadType::getLoadTypeMaterial();
            $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
            $data['operationalHours'] = Helper::fetchOnlyData($this->wh->getGeneralOperationalHours());
            return view('admin.wh.create')->with(compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function whCreateOrUpdate(Request $request)
    {

        try {
            $roleUpdateOrCreate = $this->wh->updateOrCreate($request, $request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function destroy($id)
    {

        try {
            $res = $this->wh->deleteWh($id);
            return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $res = $this->wh->editWh($id);
            if ($res->get('status')) {
                $data['wh'] = $res->get('data');

                $data['ltMaterial'] = LoadType::getLoadTypeMaterial();
                $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
                $data['operationalHours'] = Helper::fetchOnlyData($this->wh->getGeneralOperationalHours());

                return view('admin.wh.create')->with(compact('data'));
            } else {
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function getDoorsByWhId($id)
    {
        try {
            $res = $this->wh->getDoorsByWhId($id);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::ajaxError($res->get('message'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //whAssignFields
    public function whAssignFields(Request $request)
    {
        try {
            $request->all();
            $fieldResponse = $this->wh->storeAssignFields($request);
            if ($fieldResponse->get('status')) {
                return Helper::ajaxSuccess($fieldResponse->get('data'), $fieldResponse->get('message'));
            } else {
                return Helper::ajaxError($fieldResponse->get('message'));
            }
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    //whAssignFieldsList
    public function whAssignFieldsList(Request $request)
    {
        try {

            $saveDock = $this->wh->assignFieldsList($request);
            if ($saveDock->get('status'))
                return Helper::ajaxSuccess($saveDock->get('data'), $saveDock->get('message'));
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    //editWhAssignFields
    public function editWhAssignFields($id)
    {
        try {
            $res = $this->wh->editAssignFields($id);
            if ($res->get('data')) {
                $data['assignedFields'] = $res->get('data');
                $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
                return Helper::ajaxSuccess($data, $res->get('message'));
            } else {
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //destroyAssignedField
    public function destroyAssignedField($id)
    {

        try {
            $res = $this->wh->deleteAssignFields($id);
            return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function getDockWiseHours(Request $request)
    {

        try {
            if (!WhDock::find($request->dockId)) {
                return Helper::error('invalid dock id', []);
            }
            $whHours = $this->wh->getDockWiseOperationalHour($request);
            return Helper::success($whHours, 'data found');

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function testEmail()
    {


        //$orderId,$customerId,$statusId
        //return $res=$this->order->sendNotification(1,2,1,1);


        $statusId = 6;
        $orderId = 1;
        $customerId = 2;
        $mailContent = NotificationTemplate::where('status_id', $statusId)->first();
        if(!$mailContent){
            return Helper::error('mail content not exist');
        }




        if (!$customer = User::find($customerId)) {
            return Helper::error('customer not exist');
        }


        $mailData = [
            'subject' => 'Order Requested',
            'greeting' => 'Hello',
            'content' => $mailContent->mail_content,
            'actionText' => 'View Your Order Details',
            'actionUrl' => url('/get-order-detail/' . ($orderId)),
            'orderId' => $orderId,
            'statusId' => $statusId,
        ];
       return  $res=$customer->notify(new OrderNotification($mailData));

       // event(new SendEmailEvent($mailData,$customer));


    }


    public function pusher()
    {
        MyEvent::dispatch('abc');
    }

    public function pushData()
    {
        event(new SendNotificationEvent('TKNZ'));
        dd('event trigger');
    }




}

