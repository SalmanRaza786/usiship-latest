<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use App\Repositries\customer\CustomerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $customer;

    public function __construct(CustomerInterface $customer) {
        $this->customer = $customer;

    }

    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if (Admin::query()->where('email',$request->email)->first()){
                return $response=$this->adminLogin($request);
            }

                if (User::query()->where('email',$request->email)->first()){
                    return $response=$this->customerLogin($request);
                }

            return  Helper::createAPIResponce(true,400,'Invalid email',$request->all());



        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }
    public function adminLogin(Request $request)
    {
        try {


            if (!$admin=Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))) {
                return  Helper::createAPIResponce(true,400,'Invalid credentials',$request->all());
            }

                $data['user']=Admin::where('email',$request->email)->with('role')->first();
                $data['user']->device_id=$request->device_id;
                $data['user']->save();
                $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
                $data['userType']='employees';

            return  Helper::createAPIResponce(false,200,'Logged in successfully',$data);


        } catch (\Exception $e) {
             throw $e;

        }
    }
    public function customerLogin(Request $request)
    {
        try {

            if (!$user=Auth::guard('web')->attempt($request->only(['email','password']))) {
                return  Helper::createAPIResponce(true,400,'Invalid credentials',$request->all());
            }

            $data['user']=User::where('email',$request->email)->first();
            $data['user']->device_id=$request->device_id;
            $data['user']->save();
            $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
            $data['userType']='customer';
            return  Helper::createAPIResponce(false,200,'Logged in successfully',$data);

        } catch (\Exception $e) {
            throw $e;

        }
    }


    public function customerSignup(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(User::where('email',$request->email)->first()){
              return  Helper::createAPIResponce(true,400,'Email already exist',$request->all());
            }

              $customer = $this->customer->customerSave($request,$request->id);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'Account created successfully!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

}
