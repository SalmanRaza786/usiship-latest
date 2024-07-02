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
                return response()->json(['message' => $validator->errors()], 400);

            }

            if (Admin::query()->where('email',$request->email)->first()){
                return $response=$this->adminLogin($request);

            }

                if (User::query()->where('email',$request->email)->first()){
                    return $response=$this->customerLogin($request);


                }

            return  Helper::createAPIResponce(true,403,'Invalid email',[]);


        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,403,$e->getMessage(),[]);

        }
    }
    public function adminLogin(Request $request)
    {
        try {


            if (!$admin=Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))) {
                return response()->json(['message' => 'Invalid credentials.'], 400);

            }

                $data['user']=Admin::where('email',$request->email)->with('role')->first();
                $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
                $data['userType']='employees';
                return $data;

        } catch (\Exception $e) {
             throw $e;

        }
    }
    public function customerLogin(Request $request)
    {
        try {

            if (!$user=Auth::guard('web')->attempt($request->only(['email','password']))) {
                return response()->json(['message' => 'Invalid credentials.'], 400);
            }

            $data['user']=User::where('email',$request->email)->first();
            $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
            $data['userType']='customer';
            return $data;
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
                return  Helper::error($validator->errors());
            }

            if(User::where('email',$request->email)->first()){
                return Helper::error('Email already exist');
            }

           return $customer = $this->customer->customerSave($request,$request->id);





        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

}
