<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WareHouseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderContactController;
use App\Http\Controllers\Api\CheckInController;
use App\Http\Controllers\Api\OffLoadingController;
use App\Http\Controllers\Api\PutAwayController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\HomeController;


    Route::group(['middleware' => ['auth:sanctum']], function(){

        //Home
        Route::any('/admin-home', [HomeController::class, 'adminHome']);

    Route::any('/ware-house-list', [WareHouseController::class, 'wareHouseList']);
    Route::any('/dock-operational-hour', [WareHouseController::class, 'dockOperationalHour']);
    Route::any('/get-load-types', [WareHouseController::class, 'getLoadTypes']);
    Route::any('/get-wh-day-times', [WareHouseController::class, 'getWhDayTimes']);
    Route::any('/save-orders', [OrderController::class, 'saveOrders']);

    Route::any('/order-detail', [OrderController::class, 'getOrderDetail']);
    Route::any('/get-wh-doors', [WareHouseController::class, 'getDoorsByWhId']);
    Route::any('/get-orders-list', [OrderController::class, 'getOrdersList']);


    Route::any('/get-all-status', [OrderController::class, 'getAllStatus']);
    Route::any('/load-wise-docks', [WareHouseController::class, 'loadTypeWiseDocks']);
    Route::any('/get-wh-load-types', [WareHouseController::class, 'getWhLoadTypes']);

    Route::any('edit-order-form', [OrderController::class, 'editOrderForm']);
    Route::any('update-order-form', [OrderController::class, 'updateOrderForm']);

    Route::any('edit-schedule', [OrderController::class, 'editSchedule']);
    Route::any('update-schedule', [OrderController::class, 'updateScheduleForm']);
    Route::any('cancel-order', [OrderController::class, 'cancelOrder']);

    Route::any('/upload-packaging-list', [OrderController::class, 'importPackagingList']);


    Route::any('/get-order-contacts-list', [OrderContactController::class, 'getOrderContactList']);
    Route::any('/save-check-in', [CheckInController::class, 'checkinCreateOrUpdate']);
    Route::any('/get-order-check-in-list', [CheckInController::class, 'getOrderCheckIList']);
    Route::any('/check-order-checkin-id', [OffLoadingController::class, 'checkOrderCheckInId']);
    Route::any('/save-off-loading', [OffLoadingController::class, 'offLoadingCreateOrUpdate']);
    Route::any('/close-off-loading', [OffLoadingController::class, 'closeOffLoading']);
    Route::any('/save-off-loading-images', [OffLoadingController::class, 'saveOffLoadingImages']);

    //Putaway Items
    Route::any('/put-away-list', [PutAwayController::class, 'putAwayList']);
    Route::post('/store-put-away', [PutAwayController::class, 'storePutAway']);
    Route::any('/create-put-away-content/{offLoadingId}', [PutAwayController::class, 'createPutAway']);
    Route::get('/delete-putaway-item', [PutAwayController::class, 'deletePutAwayItem']);
    Route::get('/check-putaway-status', [PutAwayController::class, 'checkPutAwayStatus']);
    Route::get('/close-putaway', [OffLoadingController::class, 'closeItemPutAway']);


    Route::any('/get-off-loading-data', [OffLoadingController::class, 'packagingListConfirmation']);
    Route::any('/update-off-loading-packaging-list', [OffLoadingController::class, 'updateOffLoadingPackagingList']);


    //Notifications
    Route::get('/get-unread-notification', [NotificationController::class, 'getUnreadNotifications']);
    Route::get('/read-notification', [NotificationController::class, 'readNotification']);


  });

Route::any('/app-setting', [HomeController::class, 'appSetting']);


    Route::any('/api-login', [AuthController::class, 'login']);
    Route::any('/customer-signup', [AuthController::class, 'customerSignup']);
    Route::any('/upload-file', [OrderController::class, 'uploadFile']);

