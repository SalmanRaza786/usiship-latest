<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\AppointmentController;
use App\Http\Controllers\Admin\WareHouseController;
use App\Http\Controllers\Admin\LoadTypeController;
use App\Http\Controllers\Admin\DockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\QrCodeController;


Auth::routes();




    Route::middleware(['auth','verified'])->name('user.')->group(function () {

    Route::get('/book-appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    Route::get('/appointments', [AppointmentController::class, 'showAppointmentList'])->name('appointment.show-list');
    Route::any('/appointment-list', [AppointmentController::class, 'appointmentList'])->name('appointment.list');
    Route::any('/edit-appointment/{id}', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::any('/cancel-appointment/{id}', [AppointmentController::class, 'cancelAppointment'])->name('appointment.cancel');
    Route::any('/upload-packaging-list', [AppointmentController::class, 'uploadPackagingList'])->name('appointment.upload-list');
    Route::any('/get-order-detail/{id}', [OrderController::class, 'getAppointmentDetail'])->name('orders.detail');

    });


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('user.index');


    Route::get('/custom-logout', [HomeController::class, 'customLogout']);
    Route::any('/upload-packaging-list', [AppointmentController::class, 'uploadPackagingList'])->name('appointment.upload-list');
    Route::any('/update-appointment', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::any('/edit-scheduling/{id}', [AppointmentController::class, 'editScheduling'])->name('scheduling.edit');
    Route::get('/get-all-wh-list', [WareHouseController::class, 'getAllWhList'])->name('wh.list.all');
    Route::any('/wh-hours-list', [WareHouseController::class, 'getGeneralOperationalHoursByWhId'])->name('wh.hours.list');
    Route::any('/wh-loadType-lists', [LoadTypeController::class, 'getAllloadListByWh'])->name('loadType.list');
    Route::any('/wh-loadType-list', [LoadTypeController::class, 'whLoadTypeList'])->name('wh.loadType.list');
    Route::any('/loadType-dock-list', [DockController::class, 'getDockListByLoadtype'])->name('appointment.loadType.dock.list');
    Route::any('/save-order', [OrderController::class, 'storeOrder'])->name('order.store');
    Route::any('/update-scheduling', [AppointmentController::class, 'updateScheduling'])->name('appointment.updateScheduling');
    Route::any('/order-timing', [OrderController::class, 'orderTiming']);
    Route::get('/dock-wise-hours', [WareHouseController::class, 'getDockWiseHours'])->name('dock.hours.list');

    Route::get('/test-email', [WareHouseController::class, 'testEmail']);
    Route::get('/pusher', [WareHouseController::class, 'pusher']);
    Route::get('push-data', [WareHouseController::class, 'pushData']);

    //welcome
    Route::get('/welcome', function () {
        return view('welcome');
    });


    //websocket
    Route::get('/websocket', function () {
        \App\Events\MessageEvent::dispatch('Hello Salman');
        dd('event trigger');
    });


    Route::get('/logout', [HomeController::class, 'customLogout'])->name('user.logout');
    Route::group([],base_path("routes/admin.php"));
    Route::get('/send-test-email', function () {
            $subject = 'Test Email Subject';
            \Illuminate\Support\Facades\Mail::to('salmanrazabwn@gmail.com')->send(new \App\Mail\TestMail($subject));
            return 'Test email sent!';
        });


    Route::get('/qr-code', [QrCodeController::class, 'show']);

