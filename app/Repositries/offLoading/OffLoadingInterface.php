<?php


namespace App\Repositries\offLoading;
interface OffLoadingInterface
{
    public function getOffLoadingList($request);
    public function checkOrderCheckInId($request);
    public function offLoadingSave($request,$id);
    public function offLoadingUpdate($request,$id);
    public function offLoadingImagesSave($request,$id);

    public function getOffLoadingListForPutAway($request);
    public function getOffLoadingInfo($id);
    public function changeOffLoadingStatus($id,$statusId);
    public function getOffLoadingListForPutAwayApi($limit);

}
