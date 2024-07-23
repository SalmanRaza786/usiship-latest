<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\packagingList\PackagingListInterface;
use Illuminate\Http\Request;

class PackagingListController extends Controller
{
    private $packginglist ;
    public function __construct(PackagingListInterface $packginglist)
    {
            $this->packginglist = $packginglist;
    }

    public function updatePackagingList(Request $request)
    {
        try {

            $roleUpdateOrCreate = $this->packginglist->updatePackagingList($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function downloadPackagingList()
    {
        try {
           return $roleUpdateOrCreate = $this->packginglist->downloadPackgingListSample();
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

}
