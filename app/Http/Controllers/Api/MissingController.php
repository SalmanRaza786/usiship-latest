<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\MissedItem;
use App\Repositries\missing\MissingInterface;
use App\Repositries\picking\PickingInterface;
use App\Repositries\wh\WhInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissingController extends Controller
{
    private $missed;
    public function __construct(MissingInterface $missed) {
        $this->missed =$missed;

    }
    public function missingList()
    {
        try {
            $res=$this->missed->getAllMissingForApi();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);


        }
    }
    public function missedDetail(Request $request)
    {
        try {

            $id=$request->query('missedId');
            $data['missedInfo']=Helper::fetchOnlyData($this->missed->getMissedInfo($id));
            $data['missedItemsDetail']=Helper::fetchOnlyData($this->missed->getMissedItems($id));
            return  Helper::createAPIResponce(false,200,'missed item detail',$data);

        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }
    public function updateStartResolve(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'missedId' => 'required',
                'updateType' => 'required'
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $qry= MissedItem::find($request->missedId);
            if(!$qry){
                return Helper::error('Invalid missing id');
            }
              $res=$this->missed->updateStartResolve($request);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }


    public function saveResolve(Request $request)
    {
        try {
            $request->all();
//            $validator = Validator::make($request->all(), [
//                'work_order_id' => 'required',
//                'picker_id' => 'required',
//                'status_code' => 'required',
//            ]);
//            if ($validator->fails()){
//                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
//            }
              $res=$this->missed->saveResolveItems($request,'api');
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
