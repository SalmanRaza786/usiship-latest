<?php


namespace App\Repositries\orderContact;
interface OrderContactInterface
{
    public function getOrderContactList($request);
    public function getAllOrderContactList();
    public function getOrderContact($request);
    public function updateOrderContact($request,$id);
    public function orderContactSave($request,$id);
    public function changeStatus($id,$status_id);

}
