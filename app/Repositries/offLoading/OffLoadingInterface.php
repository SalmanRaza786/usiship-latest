<?php


namespace App\Repositries\offLoading;
interface OffLoadingInterface
{
    public function getOffLoadingList($request);
    public function checkOrderCheckInId($request);
    public function offLoadingSave($request,$id);
    public function offLoadingImagesSave($request,$id);

}
