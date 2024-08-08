<?php


namespace App\Repositries\qc;
interface QcInterface
{
    public function getQcList($request);
    public function getQcInfo($id);
    public function updateStartQc($request);
    public function getQcItems($qcId);
    public function createQcItems($request);
    public function getAllMissingForApi();
    public function updateQcItems($request);

}
