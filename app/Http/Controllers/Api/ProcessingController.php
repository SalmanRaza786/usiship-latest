<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderProcessing;
use App\Repositries\processing\ProcessingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcessingController extends Controller
{
    private $processing;
    private $wh;
    private $qc;
    public function __construct(ProcessingInterface $processing) {
        $this->processing =$processing;
    }


    public function processingDetail(Request $request)
    {
        try {
            $id=$request->query('processingId');
            if(!$process=OrderProcessing::find($id)){
                return  Helper::createAPIResponce(true,400,'Invalid Processing id',[]);
            }
            $data['orderInfo']=Helper::fetchOnlyData($this->processing->getProcessInfo($id));
            $data['processingItems']=Helper::fetchOnlyData($this->processing->getProcessItems($id));
            $data['tasks']=Helper::fetchOnlyData($this->processing->getProcessTasks());
            return  Helper::createAPIResponce(false,200,'processing detail',$data);
        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }
    public function processingList()
    {

        try {
            $res=$this->processing->getAllProcessForApi();
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    public function updateProcessingItem(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'work_order_id' => 'required',
                'processDetailId' => 'required',
                'itemId' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $res=$this->processing->createProcessItems($request);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
    public function removeProcessingItem(Request $request)
    {
        try {
            $res=$this->processing->deleteProcessItems($request);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    public function updateStartProcessing(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'process_id' => 'required',
                'updateType' => 'required',
                'status_code' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $res=$this->processing->updateStartProcess($request);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));

        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
