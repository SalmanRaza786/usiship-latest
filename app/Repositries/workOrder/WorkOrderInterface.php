<?php


namespace App\Repositries\workOrder;
interface WorkOrderInterface
{
    public function getWorkOrderList($request);
    public function getWorkOrder($request);
    public function importWorkOrder($request);
    public function savePickerAssign($request);
    public function getAllWorkOrderList();
}
