<?php


namespace App\Repositries\processing;
interface ProcessingInterface
{
    public function getProcessList($request);
    public function getProcessInfo($id);
    public function updateStartProcess($request);
    public function getProcessItems($qcId);
    public function getProcessTasks();
    public function createProcessItems($request);
    public function getAllProcessForApi();
    public function updateProcessItems($request);
    public function deleteProcessItems($request);

}
