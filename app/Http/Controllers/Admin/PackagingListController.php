<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\PackgingList;
use App\Models\User;
use App\Notifications\CloseArrivalNotification;
use App\Notifications\ReportExceptionNotification;
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
    public function reportException(Request $request)
    {
        try {
                $orderContact=PackgingList::where('order_id',$request->order_id);
                if(!$orderContact){
                    return Helper::error('Order Packaging List Not Found');
                }
                $roleUpdateOrCreate =  $this->packginglist->getPackagingListExceptions($request->order_id,$request->id);
                if ($roleUpdateOrCreate->get('status')) {
                        $this->reportExceptionNotification($roleUpdateOrCreate->get('data'));
                    return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
                }else{
                    return Helper::ajaxError($roleUpdateOrCreate->get('message'));
                }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function downloadPackagingList()
    {
        try {
           return $roleUpdateOrCreate = $this->packginglist->downloadPackgingListSample();
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public  function reportExceptionNotification($exceptionList)
    {
        try {

            $customer_id = "";
            $exceptionImagesDoc = collect([]);
            $tableHtml = '<table>';
            $tableHtml .= '<thead><tr><th>Exception ID</th><th>Field Name</th><th>File Name</th></tr></thead>';
            $tableHtml .= '<tbody>';

            foreach ($exceptionList as $excep) {
                $customer_id = $excep->order->customer_id;

                foreach ($excep->filemedia as $media) {
                    if ($media->field_name == 'damageImages') {
                        $fileMedia = array(
                            'display_name' => $media->field_name,
                            'file_name' => $media->file_name,
                        );

                        $exceptionImagesDoc->push($fileMedia);
                    }
                    $tableHtml .= '<tr>';
                    $tableHtml .= '<td>' . htmlspecialchars($excep->id) . '</td>';
                    $tableHtml .= '<td>' . htmlspecialchars($media->field_name) . '</td>'; // Adjusted to show field name
                    $tableHtml .= '<td>' . htmlspecialchars($media->file_name) . '</td>'; // Adjusted to show file name
                    $tableHtml .= '</tr>';
                }


            }

            $tableHtml .= '</tbody></table>';

            $mailData = [
                'subject' => 'Report Exception/Damages Items',
                'greeting' => 'Hello',
                'content' => 'Here are the documents attached for your reference',
                'attachments' => $exceptionImagesDoc,
                'tableHtml' => $tableHtml, // Include the generated table HTML
            ];

            if (!$customer = User::find($customer_id)) {
                return Helper::error('customer not exist');
            }

            $customer->notify(new ReportExceptionNotification($mailData));




        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

}
