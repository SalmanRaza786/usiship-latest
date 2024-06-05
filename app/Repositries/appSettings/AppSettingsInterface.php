<?php


namespace App\Repositries\appSettings;
interface AppSettingsInterface
{

    public function update($request);
    public function getAppSettings();
    public function getKeyAppSettingInfo($key);


}
