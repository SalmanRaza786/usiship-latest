<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\LoadType;
use App\Models\User;
use App\Models\WhDock;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\notification\NotificationRepositry;
use App\Repositries\wh\WhInterface;
use App\Services\FireBaseNotificationTriggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;


class WareHouseController extends Controller
{
    private $wh;
    private $customField;
    private $order;

    public function __construct(WhInterface $wh, CustomFieldInterface $customField,AppointmentInterface $order)
    {
        $this->wh = $wh;
        $this->customField = $customField;
        $this->order = $order;

    }

    public function index()
    {

        try {
            return view('admin.wh.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
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
      //  $response = Http::post($url, $params);


//    use GuzzleHttp\Client;
//        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ya29.c.c0ASRK0GbK8eKtIpWrseoUgxx3GP-yyi1Hc9lU6DYxdeny9NIoF4qf31FgTEn3KlZCrToZWWAsvTiHUOdC1kcjvq2nABVSw_T9xYhYgqeo7kvswBUDqQw29Xx5YVpko-69JcMUljvighfB21aexKENdFy4EkWj8J701EBKFroABfrL0otKxRYF8U_toJIL5k4VHSbsMCZYE8jD2RWlYCsuZLSanFlxVSxSdfpsx_ugGcf9XMS7AmnXceIbWq18mpdc7PMcIk12TL07j6VQw4FvUfVmwA2hgkrgZy0gmL3wsHIU9CBD9ofK2BggxPUUG3gSYV1t_P4Ti55xl2EV7w_T4XbhLXmspv1rjExJmJSzY0ZMGVOIxw4jf2oT384Dj3qw7uYkr2mgjnc5k2QIoMcvM3ecxd8ZR7tbSIM7B5WXV9Wl4tqlMt429y8902W18yZ_wJt7lIBgsWctOdlm9FJB6YBzuYmyf-Rc1alnSsmWBkjj9lQh7m060ygq5aFxB_uM6rJIy0SJtVUb7heFqxgkqj0Omq9Rymj-uhxSB0vVvkgryYbql8Up0bkyMcuyh0c878Jn1ag8VrYZw1Yg13Qtf95wVFmelMlq7b79XhfOYxlVnsRBl5yiUUdr6cqIac_kBZaexj6UywiaMXp1z3MWgfpuScZcb9e0Y2Uo2vwcXs19VOJkx-X0ia6ed_sxl3biX4nSdpQpkmbUbJ8wRigRRMqsu3l263grWrxOrooMuhu82OrJU9bikftnB0sue9ft0gM3ZhI3avd5ZxjSXbWxu_j4IRrplbk6FY5on6v9VYnRu65QQuu74itsJJQU18qkWr2Um_ZfqR1dn9pX-un6glUagF_om2-fmw-4Q1IraXFvqOV10lMBuglRx1QomYvJ3z7IknhF_Fai-yUd2Jxl7luIzrUOYpa5jpnWbckwaZc9YgWIQdZgik0JgxqV1bdd41ZWVduXqRgbbZbq8BlrYmVxjmXqBiiqdmcokW27xRxkMi68d5jS-8k'
        ];

        $body = [
            'message' => [
                'token' => 'c5bglgozQ2iP9AEjcpdl1E:APA91bFjmPI0UScgid-lLVLOnBq7NnG14ZEJIoLvdG5LbWT-McW0F2sty3Bsc14CiZ-tBOCvpZq2pt-nedhdPhWIsryZH03sDwZmuc_WgLe9O45znKitJMU1Ih2zVZBLA9DjvLix2AAv',
                'notification' => [
                    'body' => 'This is my magic, Salman',
                    'title' => 'FCM Message',
                ],
                'data' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                ],
            ],
        ];

//        $response = $client->post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
//            'headers' => $headers,
//            'json' => $body,
//        ]);

        $response= Http::post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
            'headers' => $headers,
            'json' => $body,
        ]);

        echo $response->getBody();

    }
    public function  test()
    {

        $type=2;
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


}

