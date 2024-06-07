<?php


namespace App\Repositries\checkIn;
interface CheckInInterface
{
    public function getCheckinList($request);
    public function findCheckIn($id);
    public function checkinSave($request,$id);

}
