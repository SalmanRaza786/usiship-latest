<?php


namespace App\Repositries\picking;
interface PickingInterface
{
    public function getAllPickers($request);
    public function getAllPickersForApi();
    public function getPickerInfo($id);
    public function updateStartPicking($request);
    public function getPickingItems($pickerId);
    public function savePickedItems($request);

}
