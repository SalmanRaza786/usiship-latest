<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Language;
use App\Models\PermissionModule;
use App\Models\User;
use App\Repositries\course\CourseInterface;
use App\Repositries\roles\RoleInterface;
use App\Repositries\user\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $user;
    private $role;
    public function __construct(UserInterface $user ,RoleInterface $role) {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(){

        try {
            $response=$this->role->getAllRoles();
              $data['roles']= $response->get('data');
            return view('admin.user.index')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    public function userList(Request $request){
        try {
            $res=$this->user->getUserList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

//userCreateOrUpdate

    public function userCreateOrUpdate(Request $request)
    {

        try {

             $roleUpdateOrCreate = $this->user->userSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

             }

    public function destroy($id)
    {

        try {
            $res = $this->user->deleteUser($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $res= $this->user->editUser($id);
            if($res->get('data')){
                $data['users']=$res->get('data');
                $role=$this->role->getAllRoles();
                $data['roles']=$role->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
