<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\appSettings\AppSettingsInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $appSetting;


    public function __construct(AppSettingsInterface $appSetting) {
        $this->appSetting = $appSetting;

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

            $res = $this->wh->getWareHousesWithOperationHour($request);
            if($res->get('status')){
                return  Helper::createAPIResponce(false,200,'Warehouse List',$res->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,'Warehouse list empty',$res->get('data'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
