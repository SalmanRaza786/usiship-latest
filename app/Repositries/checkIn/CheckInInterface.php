<?php


namespace App\Repositries\checkIn;
interface CheckInInterface
{
    public function getCheckinList($request);
    public function checkinSave($request,$id);

}
