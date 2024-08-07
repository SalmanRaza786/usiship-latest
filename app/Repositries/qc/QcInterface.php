<?php


namespace App\Repositries\qc;
interface QcInterface
{
    public function getQcList($request);
    public function getMissedInfo($id);
    public function updateStartResolve($request);
    public function getQcItems($qcId);
    public function saveQcItems($request);
    public function getAllMissingForApi();

}
