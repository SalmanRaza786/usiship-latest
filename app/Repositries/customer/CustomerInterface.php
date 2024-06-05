<?php


namespace App\Repositries\customer;
interface CustomerInterface
{


    public function getcustomerList($request);
    public function editcustomer($id);
    public function deletecustomer($id);
    public function customerSave($request,$id);
    public function getAllCustomers();



}
