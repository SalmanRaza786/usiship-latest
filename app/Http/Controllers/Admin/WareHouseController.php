<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\LoadType;
use App\Models\User;
use App\Models\WhDock;
use App\Models\WhLocation;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\notification\NotificationRepositry;
use App\Repositries\wh\WhInterface;
use App\Services\DataService;
use App\Services\FireBaseNotificationTriggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;


class WareHouseController extends Controller
{
    private $wh;
    private $customField;
    private $order;
    private $dataService;

    public function __construct(WhInterface $wh, CustomFieldInterface $customField,AppointmentInterface $order,DataService $dataService)
    {
        $this->wh = $wh;
        $this->customField = $customField;
        $this->order = $order;
        $this->dataService = $dataService;

    }

    public function index()
    {

        try {
            return view('admin.wh.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function search(Request $request)
    {
        // Search for locations based on the query
        $query = $request->input('query');

        // Find locations that match the query, limit to a reasonable number like 10 or 20
        $locations = WhLocation::where('loc_title', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        // Return the results as JSON
        return response()->json($locations);
    }

    public function whList(Request $request)
    {
        try {
            $res = $this->wh->getWhList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getAllWhList(Request $request)
    {
        try {
            $res = $this->wh->getAllWhList();
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::error('data not found', []);
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function getGeneralOperationalHoursByWhId(Request $request)
    {
        try {
            $res = $this->wh->getWareHousesWithOperationHour($request);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::error('data not found', []);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function createWh(Request $request)
    {
        try {
            $data['ltMaterial'] = LoadType::getLoadTypeMaterial();
            $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
            $data['operationalHours'] = Helper::fetchOnlyData($this->wh->getGeneralOperationalHours());
            return view('admin.wh.create')->with(compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function whCreateOrUpdate(Request $request)
    {

        try {
             $request->all();
            $roleUpdateOrCreate = $this->wh->updateOrCreate($request, $request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function destroy($id)
    {

        try {
            $res = $this->wh->deleteWh($id);
            return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $res = $this->wh->editWh($id);
            if ($res->get('status')) {

                $data['wh'] = $res->get('data');
                $data['ltMaterial'] = LoadType::getLoadTypeMaterial();
                $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
                $data['operationalHours'] = Helper::fetchOnlyData($this->wh->getGeneralOperationalHours());

                return view('admin.wh.create')->with(compact('data'));
            } else {
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function getDoorsByWhId($id)
    {
        try {
            $res = $this->wh->getDoorsByWhId($id);
            if ($res->get('status')) {
                return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
            } else {
                return Helper::ajaxError($res->get('message'));
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //whAssignFields
    public function whAssignFields(Request $request)
    {
        try {
            $request->all();
            $fieldResponse = $this->wh->storeAssignFields($request);
            if ($fieldResponse->get('status')) {
                return Helper::ajaxSuccess($fieldResponse->get('data'), $fieldResponse->get('message'));
            } else {
                return Helper::ajaxError($fieldResponse->get('message'));
            }
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    //whAssignFieldsList
    public function whAssignFieldsList(Request $request)
    {
        try {

            $saveDock = $this->wh->assignFieldsList($request);
            if ($saveDock->get('status'))
                return Helper::ajaxSuccess($saveDock->get('data'), $saveDock->get('message'));
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    //editWhAssignFields
    public function editWhAssignFields($id)
    {
        try {
            $res = $this->wh->editAssignFields($id);
            if ($res->get('data')) {
                $data['assignedFields'] = $res->get('data');
                $data['customFields'] = Helper::fetchOnlyData($this->customField->customFieldsForDropdown());
                return Helper::ajaxSuccess($data, $res->get('message'));
            } else {
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //destroyAssignedField
    public function destroyAssignedField($id)
    {

        try {
            $res = $this->wh->deleteAssignFields($id);
            return Helper::ajaxSuccess($res->get('data'), $res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function getDockWiseHours(Request $request)
    {

        try {
            if (!WhDock::find($request->dockId)) {
                return Helper::error('invalid dock id', []);
            }
            $whHours = $this->wh->getDockWiseOperationalHour($request);
            return Helper::success($whHours, 'data found');

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    public function testOld()
    {

        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ya29.c.c0ASRK0GaZBxFzE9VX-bz3Aip6A4rqZ8Jg0zaqbVYthdaTzk4H-_-VtLPs_dRRyF5pOZovozBeTx-j-yPT_mwFF8b1fbbMGlMJ0kUF26LSJyO7x1FFwHehQocQ2kXxHv432SpS9doN1FLYoNjSqrPJ7gqMzoJFH2lJ6gavBKQSXY6D3kGNDCOjIk61o4ke69UyBuAHuQ9am7OHhSW1sb2OqcsfWqD46l2sAUZIZ5yYNiW-TbeuLSAxAzC4HW9ETI_yvqHpejbipHzE4CklXh7RBGfe-SNTJgL6dFb12aO8PJIj-aJ6S2sjWX_k67xCMuYcYOtX21dOpLQWaMv4y6Pybe6iA3NNBD2PQSMx-txsRHoZwzL4ZXwIx14YL385Pf-B7_FXkliq4ZIfaQqI3cQn57tY_vR8_FQhgY1x0865t_B-O5zr6oF1rzQF6fia97wduQ1U1F-BSSSw_mwaQqk2sMi_-6mv2nI5BJWRBrY-tl2ny3dcmUwIv-JnVlcFzpj-QW-hWcVkdWbSub2yd3dtVrO2hnMnhlOfzgsWqnUjpt0ZyqJIOlUdaSOShS1em0wIr7io0qadwj1hSZF0yoRbZqv1usSotqidSw9BU90j8W-bMhfofBvtOn89SJBO86425O3IaBUh6tMysOiwn1wXl5iOStR6zJiw1MOF4rUXjcBaayhOyWxsbu5YWUXw89er0UeBggRUQUrW9u6v20YQi4o4bRg3-BFRae_Bltz6hb98gR0nkOkJ6zJXOMF1RVdii7rsOogrUfqJauIoxiFQmS_9n7z-0aO7jJfhelZnVFIM_h9wIkO2xwIcv76fYfwyqsJ4_56QYxRzJ527Wqt1pqagIg7fegzepyJWwb9JXYYt7ne40YRyS-eStcaJnxXlxm0MzvM49h9d5dj-k2SX8ceBgMvlM4ynd-ofF1X53IORriUm9xv6oOrV10zZF5vF77zJqR_QcVX5dMUUYo1VlqRS95hz2Jv1bc_pQevrm39o2dg_ygMe21f',
        ];

        $body = [
            'message' => [
                'token' =>'fkbZdvdzRiyqivMu6NC66g:APA91bHavhlFUu9p19gzKyZOeuoG7Cg6_eoKLWqnLV9CshPQGem0ZpEav-CA6RetdmSl2qg_xT3PtR47-AoH-W5C4JHZvCmcCcABPanSH2AsRrEMgA9hwFBmkO6glTmJo0ezA9wuGqkI',
                'notification' => [
                    'body' =>'Test',
                    'title' =>'Test',
                ],

                'data' => [
                    'id' =>'1',

                ],
            ],
        ];

        $response = $client->post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
            'headers' => $headers,
            'json' => $body,
        ]);

        echo $response->getBody();

    }
    public function  test()
    {

       return $type=2;
        $notifiableId=10;
        return  $response =Helper::fireBaseNotificationTriggerHelper($type,$notifiableId);



//        $notification=new NotificationRepositry();
//
//        if($type==1){
//              $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
//              $deviceId=Admin::where('id',$notifiableId)->pluck('device_id')->first();
//        }
//
//        if($type==2){
//            $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
//            $deviceId=User::where('id',$notifiableId)->pluck('device_id')->first();
//        }
//
//        $notifyContent= $notifyQuery->first();
//
//        $client = new Client();
//        $headers = [
//            'Content-Type' => 'application/json',
//            'Authorization' => 'Bearer '.env('FIRE_BASE_ACCESS_TOKEN'),
//        ];
//
//        $body = [
//            'message' => [
//                'token' =>$deviceId,
//                'notification' => [
//                    'body' =>$notifyContent['content'],
//                    'title' =>$notifyContent['content'],
//                ],
//
//                'data' => [
//                    'id' =>(string) $notifyContent['id'],
//                    'content' =>(string) $notifyContent['content'],
//                    'created_at' =>(string) $notifyContent['created_at'],
//                    'notifiType' =>(string) $notifyContent['notifiType'],
//                    'notifiableId' =>(string) $notifyContent['notifiableId'],
//                    'target_model_id' =>(string) $notifyContent['target_model_id'],
//                    'url' =>(string) $notifyContent['url'],
//                ],
//            ],
//        ];
//
//        $response = $client->post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
//            'headers' => $headers,
//            'json' => $body,
//        ]);
//
//        echo $response->getBody();

    }
    public function scan()
    {
        return view('scan');
    }



    public function fetchData($whId=1)
    {
        $endpoint = 'raw/warehouses/'.$whId.'/locations';

        try {
            $batchSize = 1000;
            $wmsLocations = $this->dataService->fetchAllData($endpoint);

            foreach (array_chunk($wmsLocations, $batchSize) as $batch) {
                foreach ($batch as $loc) {
                    $datetime = Carbon::parse($loc['updated_date'])->format('Y-m-d H:i:s');
                    $location = WhLocation::updateOrCreate(
                        ['wms_location_id' => $loc['id']],
                        [
                            'wms_location_id' => $loc['id'],
                            'loc_title' => $loc['name'],
                            'wms_warehouse_id' => $loc['warehouse_id'],
                            'type' => $loc['type'],
                            'wh_id' => $loc['warehouse_id'],
                            'wms_updated_date' => $datetime,
                        ]);
                }
            }


            return Helper::ajaxSuccess([], "All Locations imported from WHMS");
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }




}

