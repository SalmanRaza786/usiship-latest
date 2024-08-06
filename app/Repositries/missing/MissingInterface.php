<?php


namespace App\Repositries\missing;
interface MissingInterface
{
    public function getAllMissing($request);
    public function getMissedInfo($id);
    public function updateStartResolve($request);
    public function getMissedItems($missedId);
    public function saveResolveItems($request);
    public function getAllMissingForApi();

}
