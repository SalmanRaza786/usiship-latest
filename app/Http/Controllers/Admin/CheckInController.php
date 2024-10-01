<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\User;
use App\Notifications\CloseArrivalNotification;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\orderContact\OrderContactInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class CheckInController extends Controller
{

    private $checkin;
    private $orderContact;
    private $wh;

    public function __construct(CheckInInterface $checkin, OrderContactInterface $orderContact,WhInterface $wh) {
        $this->checkin = $checkin;
        $this->orderContact = $orderContact;
        $this->wh = $wh;
    }
    public function index(Request $request){
        try {
            $type = $request->input('type');
            return view('admin.checkin.index')->with(compact('type'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    //checkinView
    public function checkinView($orderContactId){
        try {

            $checkIn=OrderCheckIn::where('order_contact_id',$orderContactId)->first();
            if(!$checkIn){
                return redirect()->back()->with('error','Invalid order contact or check in id');
            }

         $checkInData=Helper::fetchOnlyData($this->checkin->findCheckIn($checkIn->id));


            $data['orderContacts']=array(

                'check_in_id'=>$orderContactId,
                'order_id'=>$checkInData->order_id,
                'order_contact_id'=>$checkInData->order_contact_id,
                'door_id'=>$checkInData->door_id,
                'container_number'=>$checkInData->container_no,
                'seal_number'=>$checkInData->seal_no,
                'delivery_number'=>$checkInData->delivery_order_signature,
                'other_document'=>$checkInData->other_document,

                'container_image'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','containerImages')->pluck('file_name')->last():'',
                'containerFileId'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','containerImages')->pluck('id')->last():0,
                'seal_image'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','sealImages')->pluck('file_name')->last():'',
                'sealFileId'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','sealImages')->pluck('id')->last():0,
                'delivery_signature_image'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','do_signatureImages')->pluck('file_name')->last():'',
                'deliverySignatureId'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','do_signatureImages')->pluck('id')->last():0,
                'other_document_image'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','other_docImages')->pluck('file_name')->last():'',
                'otherDocFileId'=> count($checkInData->checkInMedia)?$checkInData->checkInMedia->where('field_name','other_docImages')->pluck('id')->last():0,

            );

            $data['doors'] = Helper::fetchOnlyData($this->wh->getDoorsByWhId($checkInData->order->wh_id));

            return view('admin.checkin.checkin-view')->with(compact('data'));
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

            $orderContact=OrderContacts::find($request->order_contact_id);
           if($orderContact && $orderContact->vehicle_number != $request->container_no){
                return Helper::error('Invalid container number');
           }
          $roleUpdateOrCreate = $this->checkin->checkinSave($request,$request->orderCheckInId);
            if ($roleUpdateOrCreate->get('status')) {
                if($request->orderCheckInId==0) {
                    $this->closeArrivalNotification($request->order_contact_id);
                }
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
            }else{
                return Helper::ajaxError($roleUpdateOrCreate->get('message'));
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
