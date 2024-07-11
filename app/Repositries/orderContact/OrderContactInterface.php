<?php


namespace App\Repositries\orderContact;
interface OrderContactInterface
{
    public function getOrderContactList($request);
    public function getAllOrderContactList($limit);
    public function getOrderContact($contactId);
    public function updateOrderContact($request,$id);
    public function orderContactSave($request,$id);
    public function changeStatus($id,$status_id);

}
