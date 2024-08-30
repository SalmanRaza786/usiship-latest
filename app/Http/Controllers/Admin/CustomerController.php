<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\CustomerCompany;
use App\Models\User;
use App\Notifications\OrderNotification;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\customerCompanies\CustomerCompaniesInterface;
use App\Repositries\loadType\loadTypeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    private $customer;
    private $companies;

    public function __construct(CustomerInterface $customer,CustomerCompaniesInterface $companies) {
        $this->customer = $customer;
        $this->companies = $companies;
    }
    public function index()
    {
        try {
            $data['companies'] = $this->companies->getAllCompanies();
            return view('admin.customer.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }
    public function customerList(Request $request){

        try {
            $res=$this->customer->getcustomerList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function customerCreate(Request $request)
    {
        try {

            $roleUpdateOrCreate = $this->customer->customerSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                if($request->send_email)
                 {
                    $customerdata = $roleUpdateOrCreate->get('data');
                    $mailData = [
                        'subject' => 'Welcome Email',
                        'greeting' => 'Hello '.$customerdata->name,
                        'content' => "We're thrilled to have you as a part of our community as a contact of " .($customerdata->company->title??"-"). ". Globally known for our ability to handle every last detail of our customers’ particular logistics and forwarding needs, USI Ship Special Services team takes care of all your logistics. we are here to support you every step of the way.",
                        'actionText' => 'Click to Login',
                        'actionUrl' => url('/login'),
                        'orderId' =>1,
                        'statusId' => 1,
                    ];
                    if (!$customer = User::find($customerdata->id)) {
                        return Helper::error('customer not exist');
                    }
                    $res=$customer->notify(new OrderNotification($mailData));
                }
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }else{
                return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function loadCreateOrUpdate(Request $request)
    {
        try {

            $roleUpdateOrCreate = $this->customer->customerSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
//customer edit
    public function edit($id)
    {
        try {
            $res= $this->customer->editcustomer($id);
            if($res->get('data')){
                $data['load']=$res->get('data');
                $data['companies']=$this->companies->getAllCompanies();
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
//customer delete
    public function destroy($id)
    {

        try {
            $res = $this->customer->deletecustomer($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function test()
    {
        return view('test');
    }
}
