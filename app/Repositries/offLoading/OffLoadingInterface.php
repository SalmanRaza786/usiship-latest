<?php


namespace App\Repositries\offLoading;
interface OffLoadingInterface
{
    public function getOffLoadingList($request);
    public function offLoadingSave($request,$id);

}
