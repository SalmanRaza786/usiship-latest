<?php

namespace App\Repositries\appSettings;

use App\Http\Helpers\Helper;
use App\Models\AppSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use DataTables;


class AppSettingsRepositry implements AppSettingsInterface
{
    public function update($request)
    {

        try {
            DB::beginTransaction();
            $data = $request->except('_token');
            $setting = new AppSetting();

            if(isset($data['app_logo'])){
                $logo_img_name=$setting->uploadImage($data['app_logo'], 'appsettings');
                $data['app_logo'] = $logo_img_name;
            }
            if(isset($data['admin_bg'])){
                $admin_img_name=$setting->uploadImage($data['admin_bg'], 'appsettings');
                $data['admin_bg'] = $admin_img_name;
            }
            if(isset($data['student_bg'])) {
                $student_img_name = $setting->uploadImage($data['student_bg'], 'appsettings');
                $data['student_bg'] = $student_img_name;
            }

            foreach ($data as $key => $value) {
                $course=AppSetting::updateOrCreate(
                    ['key'=> $key],
                    [
                        'value'=> $value,
                    ]
                );
             }

             $message =__('translation.record_updated');
            DB::commit();

            return Helper::success($data, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }


    public function getAppSettings()
    {
        try {
            $qry= AppSetting::query();
            $qry= $qry->select('id','key','value','description');
            $data = $qry->get();
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function getKeyAppSettingInfo($key)
    {
        try {
            $qry= AppSetting::query();
            $qry= $qry->where('key',$key);
            $data = $qry->first();
            return $data->value;

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
}
