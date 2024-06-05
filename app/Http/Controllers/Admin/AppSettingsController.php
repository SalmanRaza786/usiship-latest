<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\appSettings\AppSettingsInterface;
use App\Repositries\language\LanguageRepositry;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    private $appsetting;


    public function __construct(AppSettingsInterface $appsetting)
    {
        $this->appsetting = $appsetting;
    }

    public function index()
    {

        try {
            $settings = $this->appsetting->getAppSettings();
            $data['appSetting'] = $settings->get('data');
            return view('admin.appsettings.index')->with(compact('data'));
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    public function update(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->appsetting->update($request);
            if ($roleUpdateOrCreate->get('status')) {
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'), $roleUpdateOrCreate->get('message'));
            }else{
              return  $roleUpdateOrCreate->get('message');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
