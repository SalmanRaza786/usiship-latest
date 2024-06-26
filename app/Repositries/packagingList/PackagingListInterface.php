<?php


namespace App\Repositries\packagingList;
interface PackagingListInterface
{
    public function updatePackagingList($request,$id);
    public function downloadPackgingListSample();
    public function getRecvQty($orderId,$inventoryId);

}
