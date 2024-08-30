<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\DeviceToken;
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
    public function forgetPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

//            return $request->all();
            return  Helper::createAPIResponce(false,200,'Valid email',$request->all());

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

                $data['user']=Admin::where('email',$request->email)->with('role.permissions')->first();

                $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;

                $data['userType']='employees';
                 $this->deviceTokenCreateOrUpdate($data['accessToken'],$data['user']->id,'App\Models\Admin',$request->device_id);

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

            $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
            $data['userType']='customer';
            $this->deviceTokenCreateOrUpdate($data['accessToken'],$data['user']->id,'App\Models\User',$request->device_id);
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
    public function deviceTokenCreateOrUpdate($accessToken,$authId,$authType,$deviceToken)
    {
        try {

            $deviceToken = DeviceToken::updateOrCreate(
                [
                    'access_token' => $accessToken
                ],
                [
                    'auth_id'=> $authId,
                    'auth_type'=> $authType,
                    'device_token' =>$deviceToken,
                    'access_token' => $accessToken,
                ]
        );

            return $deviceToken;

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }


    public function logout(Request $request)
    {
        try {

            if(!$request->user()){
                return  Helper::createAPIResponce(true,400,'invalid access token',[]);
            }

              $authorizationHeader = $request->header('Authorization');
            if ($authorizationHeader) {
                $parts = explode(' ', $authorizationHeader);
                if (count($parts) === 2 && $parts[0] === 'Bearer') {
                      $token = $parts[1];
                }
            }

            $res=DeviceToken::where('access_token',$token)->delete();
            $request->user()->currentAccessToken()->delete();

            return  Helper::createAPIResponce(false,200,'Logged out successfully',[]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }

}
