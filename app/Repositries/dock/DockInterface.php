<?php


namespace App\Repositries\dock;
interface DockInterface
{
    public function dockList($request,$wh_id);
    public function getDockListByLoadtype($loadTypeId,$whId);
    public function editDock($id);
    public function deleteDock($id);
    public function storeUpdateDock($request,$id);
    public function dockInfo($dockId,$loadTypeId);


}
