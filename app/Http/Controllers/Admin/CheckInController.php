<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\User;
use App\Notifications\CloseArrivalNotification;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class CheckInController extends Controller
{

    private $checkin;
    private $orderContact;

    public function __construct(CheckInInterface $checkin, OrderContactInterface $orderContact) {
        $this->checkin = $checkin;
        $this->orderContact = $orderContact;
    }
    public function index(){
        try {
            return view('admin.checkin.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function checkInList(Request $request){
        try {
            $res=$this->checkin->getCheckinList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function checkinCreateOrUpdate(Request $request)
    {
        try {
             $request->all();
          $roleUpdateOrCreate = $this->checkin->checkinSave($request,$request->order_contact_id);
            if ($roleUpdateOrCreate->get('status')) {
                $this->closeArrivalNotification($request->order_contact_id);
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public  function findCheckIn($checkinId)
    {
        try {
            $res= $this->checkin->findOrderContact($checkinId);
            if ($res->get('status')){
                return Helper::success($res->get('data'),$res->get('message'));
            }else{
                return Helper::error($res->get('message'),[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //closeArrivalNotification
    public  function closeArrivalNotification($contactId)
    {
        try {

             $orderContactInfo=Helper::fetchOnlyData($this->orderContact->getOrderContact($contactId));

            $closeArrivalDoc=collect([]);
            foreach ($orderContactInfo->filemedia as $contactMedia){
                $fileMedia=array(
                    'display_name'=>$contactMedia->field_name,
                    'file_name'=>$contactMedia->file_name,
                );
                $closeArrivalDoc->push($fileMedia);
            }

            foreach ($orderContactInfo->carrier->docimages as $carrierMedia){
                $fileMedia=array(
                    'display_name'=>$carrierMedia->field_name,
                    'file_name'=>$carrierMedia->file_name,
                );
                $closeArrivalDoc->push($fileMedia);
            }
                            $mailData = [
                                'subject' => 'Close Arrival Notification',
                                'greeting' => 'Hello',
                                'content' =>'Here are the documents attached for your reference',
                                'attachments'=>$closeArrivalDoc
                            ];

            if (!$customer = User::find($orderContactInfo->order->customer_id)) {
                return Helper::error('customer not exist');
            }
            $customer->notify(new CloseArrivalNotification($mailData));


        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }


}
