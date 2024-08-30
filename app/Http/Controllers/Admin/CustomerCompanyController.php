<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\customerCompanies\CustomerCompaniesInterface;
use Illuminate\Http\Request;

class CustomerCompanyController extends Controller
{
    private $companies;

    public function __construct(CustomerCompaniesInterface $companies) {
        $this->companies = $companies;

    }
    public function index(){

        try {
            $data['departments']=Helper::fetchOnlyData($this->companies->getAllCompanies());
            return view('admin.customer-companies.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }


    public function companiesCreateOrUpdate(Request $request)
    {
        try {

            $roleUpdateOrCreate = $this->companies->companiesSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function companiesList(Request $request){
        try {
            $res=$this->companies->companiesList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function destroy($id)
    {

        try {
            $res = $this->companies->deleteCompanies($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $res= $this->companies->editCompanies($id);
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
}
