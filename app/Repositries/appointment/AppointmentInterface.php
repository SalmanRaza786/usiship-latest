<?php


namespace App\Repositries\appointment;
interface AppointmentInterface
{
    public function getAppointmentList($request);

    public function uploadPackagingList($request);
    public function checkOrderId($request);
    public function verifyWarehouseId($request);
    public function editAppointment($id);
    public function editAppointmentScheduling($id);
    public function deleteAppointment($id);
    public function updateOrCreate($request,$id);
    public function updateOrCreatePackagingInfo($request,$id);
    public function savePackagingImages($request);
    public function fileUpload($request);
    public function updateScheduling($request,$id);
    public function getAllOrders();
    public function getOrderDetail($id);
    public function getPackagingListByOrderId($id);
    public function cancelAppointment($id);

    public function saveFormFields($request,$orderId);
    public function createOrderLog($logData);
    public function getAllStatus();
    public function changeOrderStatus($orderId,$orderStatus);
    public function createBookedSlots($orderId);
    public function checkBookedSlot($allowedSlots,$operationHourId,$orderDate,$whId);

    public function bookedSlotsMakedFree($orderId,$orderStatus);
    public function undoOrderStatus($orderId);
    public function sendNotification($orderId,$customerId,$statusId,$notificationFor);
    public function sendNotificationViaEmail($orderId,$customerId,$statusId,$notifyContent);
    public function mediaUpload($fileName=null,$fileType=null,$fileableId=null,$fileableType=null,$formId=null,$fieldName=null);
}
