<?php


namespace App\Repositries\loadType;
interface loadTypeInterface
{


    public function getloadList($request,$wh_id);
    public function getAllloadListByWh($wh_id);
    public function adminLoadTypeList($request);
    public function editload($id);
    public function deleteload($id);
    public function loadSave($request,$id);
    public function getGeneralLoadTypes();
    public function getCombineLoadType($whId);


}
