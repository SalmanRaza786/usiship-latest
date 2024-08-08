<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\QcWorkOrder;
use App\Repositries\missing\MissingInterface;
use App\Repositries\qc\QcInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QcController extends Controller
{
    private $missed;
    private $wh;
    private $qc;
    public function __construct(MissingInterface $missed,WhInterface $wh,QcInterface $qc) {
        $this->missed =$missed;
        $this->wh =$wh;
        $this->qc =$qc;
    }


    public function qcDetail(Request $request)
    {
        try {
            $id=$request->query('qcId');
            if(!$qc=QcWorkOrder::find($id)){
                return  Helper::createAPIResponce(true,400,'Invalid qc id',[]);
            }
            $data['orderInfo']=Helper::fetchOnlyData($this->qc->getQcInfo($id));
            $data['qcItems']=Helper::fetchOnlyData($this->qc->getQcItems($id));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations());
            return  Helper::createAPIResponce(false,200,'missed item detail',$data);
        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }
    public function QcList()
    {

        try {
            $res=$this->qc->getAllQcForApi();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    public function updateQcItem(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'hidden_id.*' => 'required',
                'qcQty.*' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $res=$this->qc->updateQcItems($request);
            if($res->get('status')){
                $response= $this->qc->updateStartQc($request);
            }
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    public function updateStartQc(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'qc_id' => 'required',
                'updateType' => 'required',
                'status_code' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
              $res=$this->qc->updateStartQc($request);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
