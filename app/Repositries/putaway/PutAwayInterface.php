<?php


namespace App\Repositries\putaway;
interface PutAwayInterface
{
    public function putAwayList($request);
    public function updateOrCreatePutAway($request);
    public function getPutAwayItemsAccordingOffLoading($OffLoadingId);
    public function deletePutAway($id);
    public function checkPutAwayStatus($offLoadingId,$inventoryId);

}
