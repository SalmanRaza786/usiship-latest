<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\dock\DockInterface;
use App\Repositries\loadType\loadTypeInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use App\Models\OperationalHour;
use Illuminate\Support\Facades\Validator;

class WareHouseController extends Controller
{

    private $wh;
    private $load;
    private $dock;

    public function __construct(WhInterface $wh,loadTypeInterface $load, DockInterface $dock) {
        $this->wh = $wh;
        $this->load = $load;
        $this->dock = $dock;
    }
    public function wareHouseList(Request $request){
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
    public function getLoadTypes(Request $request){
        try {
             $res=$this->load->getGeneralLoadTypes($request);
            if($res->get('status')){
                return  Helper::createAPIResponce(false,200,'Load type list',$res['data']['data']);
            }else{
                return  Helper::createAPIResponce(false,200,'Load type list empty',$res['data']['data']);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //getWhDayTimes
    public function getWhDayTimes(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'wh_id' => 'required|integer',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(!WareHouse::find($request->wh_id)){
                return  Helper::createAPIResponce(true,400,'Invalid wh id',[]);
            }

            $whId=$request->wh_id;
             $workingHors=$this->wh->getWhDayWiseOperationalHours($whId);
            $dayData=collect([]);
            foreach($workingHors as $row){
                $workingHourFrom=OperationalHour::find($row->first_from_wh_id);
                $workingHourTo=OperationalHour::find($row->to_wh_id);
                $dayArray=array(
                    'dayName'=>$row->day_name,
                    'from'=>($workingHourFrom)?$workingHourFrom->working_hour:'NIL',
                    'to'=>($workingHourTo)?$workingHourTo->working_hour:'NIL',
                );
                $dayData->push($dayArray);
            }
            return  Helper::createAPIResponce(false,200,'Day wise operational hour',$dayData);
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }

    }

    public function getDoorsByWhId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'wh_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            if(!WareHouse::find($request->wh_id)){
                return Helper::error('invalid warehouse id',[]);
            }

            $res = $this->wh->getDoorsByWhId($request->wh_id);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::ajaxError($res->get('message'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function dockOperationalHour(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'dockId' =>'required',
                'loadTypeId' => 'required',
            ]);

            if ($validator->fails())
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());

            if(!WhDock::find($request->dockId)){
                return  Helper::createAPIResponce(true,400,'invalid dock id',[]);
            }
            $whHours=$this->wh->getDockWiseOperationalHour($request);
            return  Helper::createAPIResponce(false,200,'data found',$whHours);
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function loadTypeWiseDocks(Request $request){
        try {
            $request->all();
            $validator = Validator::make($request->all(), [
                'loadtype' => 'required',
                'whId'=> 'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

              $res = $this->dock->getDockListByLoadtype($request->loadtype,$request->whId);
              return  Helper::createAPIResponce(false,200,'load wise docks found',$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    //getWhLoadTypes
    public function getWhLoadTypes(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'wh_id' =>'required',
            ]);

            if ($validator->fails())
            return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());

            if(!WareHouse::find($request->wh_id)){
                return  Helper::createAPIResponce(true,400,'invalid warehouse id',[]);
            }

            $res=$this->load->getloadList($request,$request->wh_id);
            return  Helper::createAPIResponce(false,200,'Load Type List',$res['data']['data']);


        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }



}
