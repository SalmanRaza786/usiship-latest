<?php


namespace App\Repositries\user;
interface UserInterface
{


    public function getUserList($request);
    public function editUser($id);
    public function deleteUser($id);
    public function userSave($request,$id);
    public function getAllUser();



}
