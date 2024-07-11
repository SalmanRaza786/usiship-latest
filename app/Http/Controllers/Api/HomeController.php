<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\User;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\appSettings\AppSettingsInterface;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    private $appSetting;
    private $orderContact;
    private $checkIn;
    private $offLoading;
    private $appointment;


    public function __construct(AppSettingsInterface $appSetting, OrderContactInterface $orderContact,CheckInInterface $checkIn,OffLoadingInterface $offLoading,AppointmentInterface $appointment) {
        $this->appSetting = $appSetting;
        $this->orderContact = $orderContact;
        $this->checkIn = $checkIn;
        $this->offLoading = $offLoading;
        $this->appointment = $appointment;

    }
    //appSetting
    public function appSetting(Request $request){
        try {

            $res = $this->appSetting->getAppSettings($request);
            if($res->get('status')){
                return  Helper::createAPIResponce(false,200,'App Setting',$res->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,'App Setting list empty',$res->get('data'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function adminHome(Request $request){
        try {

            $data=[];
              $data['checkIn'] = Helper::fetchOnlyData($this->orderContact->getAllOrderContactList($request->limit));
              $data['offLoading'] = Helper::fetchOnlyData($this->checkIn->getOrderCheckinList($request->limit));
              $res = Helper::fetchOnlyData($this->offLoading->getOffLoadingListForPutAwayApi($request->limit));
              $data['itemPutaway'] =$res['data'];

              return  Helper::createAPIResponce(false,200,'Admin home',$data);
        } catch (\Exception $e) {
            return    Helper::createAPIResponce(false,200,$e->getMessage(),[]);
        }

    }

    public function customerHome(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if (!User::find($request->customer_id)) {
                return  Helper::createAPIResponce(true,400,'Invalid customer id',[]);
            }

            $data=[];
            return  $data['myOrders'] = Helper::fetchOnlyData($this->appointment->getMyAppointmentsForApi($request->customer_id,$request->limit));

            return  Helper::createAPIResponce(false,200,'Admin home',$data);
        } catch (\Exception $e) {
            return    Helper::createAPIResponce(false,200,$e->getMessage(),[]);
        }

    }
}
