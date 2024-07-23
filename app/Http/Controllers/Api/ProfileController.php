<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'auth_id' =>'required',
                'name' => 'required',
                'email' => 'required',
                'type' => 'required',
            ]);


            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            if($request->type==1){
                if(!Admin::find($request->auth_id)){
                    return  Helper::createAPIResponce(true,400,'Invalid auth id',[]);
                }
                $admin = Admin::updateOrCreate(
                    [
                        'id' => $request->auth_id
                    ],
                    [
                        'name' =>$request->name,
                        'email' => $request->email,
                    ]
                );
            }

            if($request->type==2){
                if(!User::find($request->auth_id)){
                    return  Helper::createAPIResponce(true,400,'Invalid auth id',[]);
                }
                $admin = User::updateOrCreate(
                    [
                        'id' => $request->auth_id
                    ],
                    [
                        'name' =>$request->name,
                        'email' => $request->email,
                    ]
                );
            }

            return  Helper::createAPIResponce(false,200,'Profile update suceesfully',$admin);
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }
}
