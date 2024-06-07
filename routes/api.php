<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WareHouseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Admin\OrderContactController;


    Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::any('/ware-house-list', [WareHouseController::class, 'wareHouseList']);
    Route::any('/dock-operational-hour', [WareHouseController::class, 'dockOperationalHour']);
    Route::any('/get-load-types', [WareHouseController::class, 'getLoadTypes']);
    Route::any('/get-wh-day-times', [WareHouseController::class, 'getWhDayTimes']);
    Route::any('/save-orders', [OrderController::class, 'saveOrders']);
    Route::any('/order-detail', [OrderController::class, 'getOrderDetail']);
    Route::any('/get-orders-list', [OrderController::class, 'getOrdersList']);
    Route::any('/get-order-contacts-list', [OrderContactController::class, 'getOrderContactList']);
    Route::any('/get-all-status', [OrderController::class, 'getAllStatus']);
    Route::any('/load-wise-docks', [WareHouseController::class, 'loadTypeWiseDocks']);
    Route::any('/get-wh-load-types', [WareHouseController::class, 'getWhLoadTypes']);
    Route::any('/upload-file', [OrderController::class, 'uploadFile']);
    Route::any('edit-order-form', [OrderController::class, 'editOrderForm']);
    Route::any('update-order-form', [OrderController::class, 'updateOrderForm']);

    Route::any('edit-schedule', [OrderController::class, 'editSchedule']);
    Route::any('update-schedule', [OrderController::class, 'updateScheduleForm']);
    Route::any('cancel-order', [OrderController::class, 'cancelOrder']);

    Route::any('/upload-packaging-list', [OrderController::class, 'importPackagingList']);


  });


Route::any('/api-login', [AuthController::class, 'login']);
Route::any('/customer-signup', [AuthController::class, 'customerSignup']);



