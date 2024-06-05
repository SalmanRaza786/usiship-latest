<?php


namespace App\Repositries\carriers;
interface CarriersInterface
{


    public function carriersList($request);
    public function editCarriers($id);
    public function deleteCarriers($id);
    public function CarriersSave($request,$id);
    public function CarriersSaveInfo($request,$id);



}
