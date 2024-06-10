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
                return Helper::success($res->get('data'),'Warehouse List');
            }else{
                return Helper::error('Warehouse list empty',[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function getLoadTypes(Request $request){
        try {
            return $res=$this->load->getGeneralLoadTypes($request);
            return Helper::success($res['data'],'Warehouse List');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //getWhDayTimes
    public function getWhDayTimes(Request $request){
        try {
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
            return Helper::success($dayData,'Day wise operational hour');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getDoorsByWhId(Request $request)
    {
        try {
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
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            if(!WhDock::find($request->dockId)){
                return Helper::error('invalid dock id',[]);
            }
            $whHours=$this->wh->getDockWiseOperationalHour($request);
            return Helper::success($whHours,'data found');

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function loadTypeWiseDocks(Request $request){
        try {
            $request->all();
            $validator = Validator::make($request->all(), [
                'loadtype' => 'required',
                'whId'=> 'required',
            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());
            return  $res = $this->dock->getDockListByLoadtype($request->loadtype,$request->whId);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //getWhLoadTypes
    public function getWhLoadTypes(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'wh_id' =>'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            if(!WareHouse::find($request->wh_id)){
                return Helper::error('invalid warehouse id',[]);
            }

            $res=$this->load->getloadList($request,$request->wh_id);
            return  Helper::success($res['data']['data'],'Load Type List');

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }



}
