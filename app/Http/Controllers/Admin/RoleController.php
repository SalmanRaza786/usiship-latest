<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\PermissionModule;
use App\Models\User;
use App\Repositries\roles\RoleInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        try {

            return view('admin.roles.index');
            } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    public function updateOrCreateRecord(Request $request)
    {

        try {
            $roleUpdateOrCreate = $this->role->updateOrCreate($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function getRoles(Request $request)
    {

        try {
            $res=$this->role->getRole($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function editRole(Request $request)
    {
        try {
            $res= $this->role->findRoleById($request->id);
            if($res->get('data')){
                return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
            } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
            }
        }
    public function deleteRole(Request $request)
    {
        try {
            $res = $this->role->deleteRole($request->id);
           return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }



}
