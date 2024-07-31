<?php


namespace App\Repositries\workOrder;
interface WorkOrderInterface
{
    public function getWorkOrderList($request);
    public function savePickerAssign($request);
}
