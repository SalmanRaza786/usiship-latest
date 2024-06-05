<?php


namespace App\Repositries\customField;
interface CustomFieldInterface
{


    public function customFieldList($request);
    public function editCustomField($id);
    public function deleteCustomField($id);
    public function customFieldSave($request,$id);
    public function customFieldsForDropdown();
    public function getFieldsAccordingWareHouse($whId);




}
