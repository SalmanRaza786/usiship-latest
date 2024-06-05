<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\PermissionModule;
use App\Repositries\course\CourseInterface;
use App\Repositries\permissions\PermissionInterface;
use App\Repositries\roles\RoleInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    private $perm;
    public function __construct(PermissionInterface $perm) {
        $this->perm = $perm;

    }
    public function assignPermissions(Request $request){
        try {
            $roleUpdateOrCreate = $this->perm->assignPermissions($request);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getRoleHasPermissions($role_id)
    {
     try {
             if(!$data['role'] = Role::find($role_id)){
                 return back()->with('error','Role not exist');
             }
              $data['roles'] = $data['role']->permissions;
             $data['permissions'] = PermissionModule::getModuleWithPermName();
             return view('admin.permissions.index')->with(compact('data'));
        }catch (\Exception $e) {
        return $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
