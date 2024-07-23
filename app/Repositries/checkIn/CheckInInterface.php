<?php


namespace App\Repositries\checkIn;
interface CheckInInterface
{
    public function getCheckinList($request);
    public function findOrderContact($id);
    public function getOrderCheckinList($limit);
    public function checkinSave($request,$id);
    public function findCheckIn($id);

}
