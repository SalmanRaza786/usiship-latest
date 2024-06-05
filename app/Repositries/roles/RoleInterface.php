<?php


namespace App\Repositries\roles;
interface RoleInterface
{
    public function getRole($request);
    public function getAllRoles();
    public function deleteRole($id);
    public function findRoleById($id);
    public function updateOrCreate($request,$id);


}
