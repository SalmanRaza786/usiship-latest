<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\loadType\loadTypeInterface;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    private $customfield;

    public function __construct(CustomFieldInterface $customfield) {
        $this->customfield = $customfield;

    }
    public function index(){

        try {
            return view('admin.customField.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    //loadCreateOrUpdate

    public function customFieldCreateOrUpdate(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->customfield->customFieldSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function customFieldList(Request $request){
        try {
            $res=$this->customfield->customFieldList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function destroy($id)
    {

        try {
            $res = $this->customfield->deleteCustomField($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $res= $this->customfield->editCustomField($id);
            if($res->get('data')){
                $data['load']=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //allCustomFields
    public function allCustomFields(Request $request){
        try {
            $res=$this->customfield->customFieldsForDropdown();
            return Helper::success($res['data'],'Fields list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //
    public function getWhFields(Request $request){
        try {
            $whId=1;//$request->wh_id;
          return  $res=$this->customfield->getFieldsAccordingWareHouse($whId);
            return Helper::success($res['data'],'fields list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
