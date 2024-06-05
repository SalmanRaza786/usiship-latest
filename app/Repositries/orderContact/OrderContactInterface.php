<?php


namespace App\Repositries\checkIn;
interface CheckInInterface
{
    public function getCheckinList($request,$wh_id);
    public function checkinSave($request,$id);
    
}
