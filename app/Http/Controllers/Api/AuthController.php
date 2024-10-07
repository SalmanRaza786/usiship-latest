<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\DeviceToken;
use App\Models\Student;
use App\Models\User;
use App\Notifications\OrderNotification;
use App\Repositries\customer\CustomerInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;

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
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $user = User::where('email', $request->email)->first();

            if ($user && $user->status == 'In-Active') {  // Assuming `is_active` is the column for the account status
                return  Helper::createAPIResponce(true,400,'Your account is inactive and cannot reset password.',[]);
            }

            $user = User::where('email', $request->email)->first();
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();
            $mailData = [
                'subject' => 'Reset Password Notification',
                'greeting' => 'Hello '.$user->name,
                'content' => "Your OTP for password reset is: " . $otp . " .If you did not request a password reset, no further action is required.",
                'actionText' => 'Visit Our Website',
                'actionUrl' => url('/'),
                'orderId' =>1,
                'statusId' => 1,
            ];
            $res=$user->notify(new OrderNotification($mailData));
            return Helper::createAPIResponce(false,200,'We have emailed your password reset OTP.',$user->email);
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|string|min:6|max:6',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $user = User::where('email', $request->email)->first();

            if ($request->otp === $user->otp) {
                return Helper::createAPIResponce(false,200,'OTP is valid. You can now reset your password.',$user->email);
            } else {
                return Helper::createAPIResponce(true,400,'Invalid OTP.',$user->email);
            }

        }catch (\Exception $e)
        {
            return Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }

    public function reset(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make( $request->password);
            $user->save();

            return Helper::createAPIResponce(false,200,'Password reset successfully',$user->email);
        }catch (\Exception $e)
        {
            return Helper::createAPIResponce(true,400,$e->getMessage(),[]);
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

            $user = User::where('email', $request->email)->first();

            if ($user && $user->status == 'In-Active') {  // Assuming `is_active` is the column for the account status
                return  Helper::createAPIResponce(true,400,'Your account is currently inactive pending approval.',[]);
            }

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
                'password' => 'required',
                'company_name' => 'required',
                'phone_no' => 'required'
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(User::where('email',$request->email)->first()){
              return  Helper::createAPIResponce(true,400,'Email already exist',$request->all());
            }

              $customer = $this->customer->customerSave($request,$request->id);

            if($customer->get('status')){
                event(new Registered(Helper::fetchOnlyData($customer)));
                return  Helper::createAPIResponce(false,200,'Account created successfully!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer->get('message'),[]);
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
