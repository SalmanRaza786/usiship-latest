<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\LoadType;
use App\Models\WhDock;
use App\Repositries\loadType\loadTypeInterface;
use App\Repositries\roles\RoleInterface;
use App\Repositries\user\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoadTypeController extends Controller
{

    private $load;

    public function __construct(loadTypeInterface $load) {
        $this->load = $load;

    }
    public function index(){

        try {
        $data['ltMaterial']=LoadType::getLoadTypeMaterial();
            return view('admin.loadType.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    //loadCreateOrUpdate

    public function loadCreateOrUpdate(Request $request)
    {

        try {

            $roleUpdateOrCreate = $this->load->loadSave($request,$request->hidden_load_type_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //whLoadCreateOrUpdate
    public function whLoadCreateOrUpdate(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'hidden_wh_id_load_type' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());


            $roleUpdateOrCreate = $this->load->loadSave($request,$request->hidden_load_type_id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function loadList(Request $request){
        try {
            $res=$this->load->getloadList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //adminLoadList

    public function destroy($id)
    {

        try {
            if(WhDock::where('load_type_id',$id)->count() > 0){
                return Helper::error('some docks linked under this load type',[]);
            }
            $res = $this->load->deleteload($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $res= $this->load->editload($id);
            if($res->get('data')){
                $data['ltMaterial']=LoadType::getLoadTypeMaterial();
                $data['load']=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function whLoadTypeList(Request $request){
        try {

            $res=$this->load->getloadList($request,$request->wh_id);
            return  Helper::success($res['data']['data'],'Load Type List');

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getAllloadListByWh(Request $request){
        try {
            $res = $this->load->getAllloadListByWh($request->wh_id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }


    public function adminLoadList(Request $request){
        try {

              $res=$this->load->adminLoadTypeList($request);
            if($res['data']['data']->count() > 0){
                $data = collect([]);
                foreach ( $res['data']['data'] as $row){
                    $array = array(
                        'id' =>$row->id,
                        'wh' =>isset($row->wareHouse)?$row->wareHouse->title:'-',
                        'direction' =>$row->direction->value,
                        'operation' =>$row->operation->value,
                        'eqType' =>$row->eqType->value,
                        'transMode' => $row->transMode->value,
                        'duration' => $row->duration . ' minutes',
                        'status' =>$row->status,
                    );
                    $data->push($array);
                }
                return Helper::ajaxDatatable($data, $res['data']['totalRecords'], $request);

            }else{
                return Helper::ajaxDatatable($res['data']['data'],$res['data']['totalRecords'], $request);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }


}
