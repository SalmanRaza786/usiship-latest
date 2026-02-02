<?php


namespace App\Repositries\wh;
interface WhInterface
{


    public function getWhList($request);
    public function getAllWhList();
    public function editWh($id);
    public function deleteWh($id);
    public function updateOrCreate($request,$id);
    public function storeAssignFields($request);
    public function assignFieldsList($request);
    public function editAssignFields($id);
    public function deleteAssignFields($id);
    public function getGeneralOperationalHours();
    public function getWareHousesWithOperationHour($request);
    public function saveWhOperationalHours($request,$wh_id);
    public function saveOffDays($request,$wh_id);
    public function getDaysSlots($dayName);
    public function getOffDays($date,$wh_id);
    public function getWhDayWiseOperationalHours($wh_id);
    public function getDockWiseOperationalHour($request);
    public function getDoorsByWhId($request);
    public function getWhLocations($whId);
    public function searchWhLocations($request);




}
