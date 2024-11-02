<?php


namespace App\Repositries\packagingList;
interface PackagingListInterface
{
    public function updatePackagingList($request,$id);
    public function downloadPackgingListSample();
    public function getPackgeingListEachQty($orderId);
    public function getPackagingListExceptions($orderId);

}
