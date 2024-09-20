<?php

namespace App\Http\Helpers;

use App\Events\ClientNotificationEvent;
use App\Events\NotificationEvent;
use App\Models\Admin;
use App\Models\Attempt;
use App\Models\FileContent;
use App\Models\MissedItem;
use App\Models\OperationalHour;
use App\Models\OrderBookedSlot;
use App\Models\Question;
use App\Models\QuestionSection;
use App\Models\QuestionSolved;
use App\Models\SignupRequest;
use App\Models\SlidesContentTranslation;
use App\Models\Student;
use App\Models\StudentAttempts;
use App\Models\User;
use App\Repositries\config\PracticeConfigRepositry;
use App\Repositries\dock\DockRepositry;
use App\Repositries\exam\ExamRepositry;
use App\Repositries\language\LanguageRepositry;
use App\Repositries\notification\NotificationRepositry;
use App\Repositries\qBank\QuestionsRepositry;
use App\Repositries\qc\QcRepositry;
use App\Repositries\student\StudentRepositry;
use App\Repositries\studentLecture\StudentLectureRepositry;
use App\Repositries\user\UserRepositry;
use App\Services\FireBaseNotificationTriggerService;
use App\Traits\HandleFiles;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Permission;

class Helper
{
    use HandleFiles;

    public static function sendError($message, $errors = [], $code = 401)
    {
        $response = ['success' => false, 'message' => $message];
        if (!empty($errors)) {
            $response['data'] = $errors;
        }
        throw new HttpResponseException(response()->json($response, $code));
    }

    public static function createAPIResponce($is_error, $code, $message, $content)
    {
        $result = [];
        if ($is_error) {
            $result['success'] = false;
            $result['code'] = $code;
            $result['message'] = $message;
            $result['data'] = $content;
        } else {
            $result['success'] = true;
            $result['code'] = $code;
            $result['message'] = $message;

            if ($content == null) {

                $result['data'] = [];
            } else {
                $result['data'] = $content;

            }
        }
        return response()->json($result,$code);

    }

    // below functions created by Ahsan
    public static function success($data, $message = 'success')
    {

        try {
            return collect(['status' => true, 'data'=> $data, 'message' => $message]);
        } catch (\Exception $exception) {
            return collect(['status' => false, 'data' => null, 'message' => $exception->getMessage()]);
        }
    }

    public static function error($message = 'success')
    {
        try {
            return collect(['status' => false, 'message' => $message]);
        } catch (\Exception $exception) {
            return collect(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public static function errorWithData($message = 'error', $data)
    {
        try {
            return collect(['status' => false, 'data' => $data, 'message' => $message]);
        } catch (\Exception $exception) {
            return collect(['status' => false, 'data' => null, 'message' => $exception->getMessage()]);
        }
    }

    public static function ajaxSuccess($data, $message = 'success')
    {
        try {
            return response()->json(collect(['status' => true, 'data'=> $data, 'message' => $message]), 200);
        } catch (\Exception $exception) {
            return response()->json(collect(['status' => false, 'data' => null, 'message' => $exception->getMessage()]), 400);
        }
    }

    public static function ajaxError($message = 'success')
    {
        try {
            return response()->json(collect(['status' => false, 'message' => $message]), 400);
        } catch (\Exception $exception) {
            return response()->json(collect(['status' => false, 'message' => $exception->getMessage()]), 400);
        }
    }

    public static function ajaxErrorWithData($message = 'error', $data)
    {
        try {
            return response()->json(collect(['status' => false, 'data' => $data, 'message' => $message]));
        } catch (\Exception $exception) {
            return response()->json(collect(['status' => false, 'data' => null, 'message' => $exception->getMessage()]));
        }
    }

    public static function ajaxDatatable($data, $totalRecords, $request){

        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => $data->count(),
            "recordsFiltered" =>$totalRecords,
            "data" => $data,

        ]);


    }

    public static  function fnUniqueDigit()
    {
        $prefix = 'BEL-';
        $suffix = '';
        $min = 100000;
        $max = 999999;

        $uniqueID = uniqid($prefix, true); // Generate a unique ID based on the current time with microsecond precision.

        // Convert the hash to an integer value and keep it within the 6-digit range.
        $randomInt = intval(substr(md5($uniqueID), 0, 8), 16);
        $randomInt %= $max - $min + 1;
        $randomInt += $min;

        // Combine prefix, random integer, and suffix to create the final 6-digit unique ID.
        return $prefix . str_pad($randomInt, 6, '0', STR_PAD_LEFT) . $suffix;
    }

    public static function fetchOnlyData($data){
        try {
            return $data->get('data');
        } catch (\Exception $exception) {
            return response()->json(collect(['status' => false, 'message' => $exception->getMessage()]), 400);
        }
    }

    public static function isResumeAllow($section)
    {
        $isResumeAllow = 1;
        if($section->status==1){
            $isResumeAllow = 0;
        }
        return $isResumeAllow;
    }
    public static function isReAttemptAllow($reattemptStatus){
        $isReAttemptAllow=0;
        if($reattemptStatus==0){
            $isReAttemptAllow=1;
        }
        return $isReAttemptAllow;
    }
    public static function createSignUpRequest($responseData){
        return $student = SignupRequest::updateOrCreate(
            [
                'traffic_id' => $responseData['data']['regnnumb'],
            ],
            [
                'traffic_id' => $responseData['data']['regnnumb'],
                'std_name' => $responseData['data']['studname'],
                'mobile_no' => $responseData['data']['mobileno'],
                'email' => $responseData['data']['email']

            ]);
    }
    public static function isSectionReattemptExist($sectionId){

        $qSetion=QuestionSection::with('solvedQuestios')->where('parent_section_id',$sectionId)->get();

        return $qSetion;
    }
    public static function getSectionReattemptCount($parentSectionId){

        return $qSetion=QuestionSection::where('parent_section_id',$parentSectionId)->count();
    }
    public static function countSectionReAttempts($attemptId){

          return $qSetion=StudentAttempts::where('attempt_id',$attemptId)->where('section_id','>',0)->count();
       ;

    }
    public static function getAttemptWiseScore($attemptId,$totalQ,$stdId){

        $exam=new ExamRepositry();
        return $res=$exam->getAttemptWiseScore($attemptId,$stdId,$totalQ);

    }
    public static function getPracticeLangCreatorName($createdBy,$id){
        $name='';
        if($createdBy=='admin'){
            $user=new UserRepositry();
            $userInfo= self::fetchOnlyData($user->editUser($id));
            $name=$userInfo->name;
        }
        if($createdBy=='self'){
            $stdInfo=Student::find($id);
            $name=$stdInfo->std_name;
        }
        return $name;
    }
    public  static  function  maskEmail($email) {
    list($username, $domain) = explode('@', $email);
    $maskedUsername = substr($username, 0, 1) . str_repeat('*', strlen($username) - 2) . substr($username, -1);
    return $maskedUsername . '@' . $domain;
}
    public static function errorChannel($message, $exception = false)
    {
        Log::channel('api')->error($message);
        $message = ($exception) ? (config('app.debug') ? $message : __('Internet Server Error! Please contact customer support')) : $message;
        return $message;
    }
    public static function getLectAttempInfo($lectConfigId)
    {
        $stdLect=new StudentLectureRepositry();
        $lectInfo=$stdLect->getLectAttemptInfo($lectConfigId,Auth::id());
        return $lectInfo;
    }

    public static function checkLectAttemptsIsComplete($lectConfigId)
    {
        $lectIsComplete=0;
        $stdLect=new StudentLectureRepositry();
        $lectInfo=$stdLect->checkLectIsComplete($lectConfigId,Auth::id());

        if($lectInfo){
            $lectIsComplete=1;
        }

        return  $lectIsComplete;
    }

    public static function getLangTitle($shoreCode)
    {
        $lang=new LanguageRepositry();
        $langTitle=$lang->getLangTitleByShortCode($shoreCode);
        return  $langTitle;
    }

    public static function getFirstLastOperationHourId()
    {
        $data['first']=OperationalHour::pluck('id')->first();
        $data['last']=OperationalHour::latest('id')->pluck('id')->first();
        return $data;
    }

    public static function getQuerySplit($data,$dayName)
    {
        $data['dayFirstRecord']=$data['wh']->whWorkingHours->where('day_name',$dayName);
        $data['daySliceRecord'] = $data['wh']->whWorkingHours->where('day_name',$dayName)->values()->slice(1);
        return $data;
    }

    public static function getDockInfo($dockId,$loadTypeId)
    {
        $dockInfo=new DockRepositry();
        return Helper::fetchOnlyData($dockInfo->dockInfo($dockId,$loadTypeId));
    }

    public static function deleteBookedSlotsAccordingOrders($orderId)
    {
      OrderBookedSlot::where('order_id',$orderId)->delete();
    }


    public static function createNotificationHelper($content,$url,$orderId)
    {
        $notification=new NotificationRepositry();
        $notification->createNotification($content,$url,$orderId);
    }

    public static function createEndUserNotificationHelper($notifyContent,$url,$endUserId,$model,$orderId)
    {
        $notification=new NotificationRepositry();
        $notification->createEndUserNotification($notifyContent,$url,$endUserId,$model,$orderId);
    }

    public static function uploadMultipleMedia($imageSets,$fileableId,$fileableType,$path)
    {
        try {
                foreach ($imageSets as $fieldName => $images) {
                    if (!is_array($images)) {
                        $images = [];
                    }
                        foreach ($images as $image) {
                            $files = self::handleFiles($image, $path);
                            $media = Helper::mediaUpload(
                                $fileName = $files['filename'],
                                $fileType = 'image',
                                $fileableId,
                                $fileableType,
                                $formId = null,
                                $fieldName,
                                $thumbnail = $files['thumbnail'],
                            );
                        }

                }
            return $media;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function createOrUpdateSingleMedia($imageFile,$fileableId,$fileableType,$path,$fileId,$fieldName)
    {
        try {
            if (!is_array($imageFile)) {
                $imageFile = [];
            } else{

                $files = self::handleFiles($imageFile, $path);

            $media = FileContent::updateOrCreate(
                [
                    'id' => $fileId
                ],
                [
                    'file_name' => $files['filename'],
                    'file_thumbnail' => $files['thumbnail'],
                    'file_type' => 'Image',
                    'fileable_id' => $fileableId,
                    'fileable_type' => $fileableType,
                    'form_id' => null,
                    'field_name' => $fieldName,
                ]);
        }


            return $media;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public static function mediaUpload($fileName=null,$fileType=null,$fileableId,$fileableType=null,$formId=null,$fieldName=null,$thumbnail=null)
    {
        try {

            if($formId != null)
            {
                $data =[
                    'fileable_id' => $fileableId,
                    'form_id' => $formId,
                ];
            }else{
                $data =[
                    'fileable_id' => 0
                ];
            }

            $media = FileContent::updateOrCreate(
                $data,
                [
                    'file_name' => $fileName,
                    'file_thumbnail' => $thumbnail,
                    'file_type' => $fileType,
                    'fileable_id' => $fileableId,
                    'fileable_type' => $fileableType,
                    'form_id' => $formId,
                    'field_name' => $fieldName,
                ]);

            return $media;

        } catch (\Exception $e) {
            throw $e;


        }

    }

    public static function handleFiles( $file, $path )
    {

        if ($file)  {
            $uniqueid = uniqid();
            $thumbnailpath = $path.'thumbnails/';
            $extension = $file->getClientOriginalExtension();
            $filename = $path.$uniqueid.'.'.$extension;
            self::ensureDirectoryExists(public_path('storage/uploads/'.$path));
            self::ensureDirectoryExists(public_path('storage/uploads/'.$thumbnailpath));
            if (getimagesize($file)) {
                $thumbnailFilename = $thumbnailpath . $uniqueid . '_thumb.' . $extension;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 300);
                $image->resize(150, 150);
                $image->toPng()->save(public_path('storage/uploads/' . $thumbnailFilename));

                $file->move(public_path('storage/uploads/' . $path), $filename);
                return [
                    'filename' => $filename,
                    'thumbnail' => $thumbnailFilename,
                ];
            }else{
                $file->move(public_path('storage/uploads/' . $path), $filename);
                return [
                    'filename' => $filename,
                    'thumbnail' => null,
                ];
            }


        }


    }

    public static function ensureDirectoryExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }


    public static function notificationTriggerHelper($type,$totifiableId)
    {
        $notification=new NotificationRepositry();

        if($type==1){
            $permission = Permission::where('name', 'admin-notification-view')->first();
            $hasPermissions = DB::table('role_has_permissions')->where('permission_id', $permission->id)->get();
            if ($hasPermissions->count() > 0) {

                foreach ($hasPermissions as $row) {
                    $users=Admin::where('role_id',$row->role_id)->get();
                    foreach ($users as $user){
                        $notifiData=Helper::fetchOnlyData($notification->getUnreadNotifications($type,$user->id));
                        $res= NotificationEvent::dispatch($notifiData);
                        $fireBaseResponse =Helper::fireBaseNotificationTriggerHelper($type,$user->id);
                    }

                }
            }

        }
        if($type==2){
            $notifiData=Helper::fetchOnlyData($notification->getUnreadNotifications($type,$totifiableId));
             $res= ClientNotificationEvent::dispatch($notifiData);
            $fireBaseResponse =Helper::fireBaseNotificationTriggerHelper($type,$totifiableId);
        }
    }


    public function numberToWords($number)
    {
        $words = [
            1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty',
            30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        ];

        if ($number <= 20) {
            return $words[$number];
        } elseif ($number < 100) {
            $tens = (int)($number / 10) * 10;
            $units = $number % 10;
            return $units ? $words[$tens] . '-' . $words[$units] : $words[$tens];
        } elseif ($number == 100) {
            return 'one hundred';
        }
    }

    public static function runQueueWorkCommand()
    {
        Artisan::call('queue:work');
        $output = Artisan::output();
        return response()->json([
            'message' => 'Queue worker started',
           'output' => $output
        ]);

    }

   public static function getMimeType($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            // Add other mime types as needed
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    public static function fireBaseNotificationTriggerHelper($type,$notifiableId)
    {
        $fb=new FireBaseNotificationTriggerService();
           $response=$fb->fireBaseTrigger($type,$notifiableId);
    }


    public static function saveQcItems($request)
    {
        $qc=new QcRepositry();
      return $res= $qc->createQcItems($request);
    }






}
