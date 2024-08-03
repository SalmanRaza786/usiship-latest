<?php


namespace App\Repositries\missing;
interface MissingInterface
{
    public function getAllMissing($request);
    public function getPickerInfo($id);
    public function updateStartPicking($request);
    public function getPickingItems($pickerId);
    public function savePickedItems($request);

}
