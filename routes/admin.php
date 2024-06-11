<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoadTypeController;
use App\Http\Controllers\Admin\WareHouseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomFieldController;

use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\CarriersController;

use App\Http\Controllers\Admin\DockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CheckInController;

use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\OrderContactController;
use App\Http\Controllers\Admin\OffLoadingController;





//Auth::routes();

    Auth::routes(['verify' => true]);


    Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/test', function () {
            return view('test');
        });

    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('dashboard');

    Route::get('/app-settings', [AppSettingsController::class, 'index'])->name('app-settings.index')->middleware(['can:admin-settings-edit']);
    Route::post('/update-app-settings', [AppSettingsController::class, 'update'])->name('app-settings.update')->middleware(['can:admin-settings-edit']);

    Route::any('/get-role-has-permissions/{role_id}', [PermissionController::class, 'getRoleHasPermissions'])->name('roles.permissions');
    Route::post('assign-permissions', [PermissionController::class, 'assignPermissions'])->name('permissions.assign');

    //Roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware(['can:admin-role-view']);
    Route::any('get-roles', [RoleController::class, 'getRoles'])->name('roles.get')->middleware(['can:admin-role-view']);
    Route::get('edit-role', [RoleController::class, 'editRole'])->name('roles.edit')->middleware(['can:admin-role-edit']);
    Route::post('add-role', [RoleController::class, 'updateOrCreateRecord'])->name('roles.add')->middleware(['can:admin-role-create']);
    Route::any('/delete-role', [RoleController::class, 'deleteRole'])->name('roles.delete')->middleware(['can:admin-role-delete']);


    //users
    Route::any('/user', [UserController::class, 'index'])->name('user.index')->middleware(['can:admin-user-view']);
    Route::any('/user-list', [UserController::class, 'userList'])->name('user.list')->middleware(['can:admin-user-view']);
    Route::any('/save-update-user', [UserController::class, 'userCreateOrUpdate'])->name('user.store')->middleware(['can:admin-user-create']);
    Route::any('/edit-user/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['can:admin-user-edit']);
    Route::any('/delete-user/{id}', [UserController::class, 'destroy'])->name('user.delete')->middleware(['can:admin-user-delete']);


    //Load Type
    Route::any('/load-type', [LoadTypeController::class, 'index'])->name('load.index')->middleware(['can:admin-load-view']);
    Route::any('/load-type-list', [LoadTypeController::class, 'loadList'])->name('load.list')->middleware(['can:admin-load-view']);
    Route::any('/save-update-load-type', [LoadTypeController::class, 'loadCreateOrUpdate'])->name('load.store')->middleware(['can:admin-load-create']);
    Route::any('/wh-store-load-type', [LoadTypeController::class, 'whLoadCreateOrUpdate'])->name('wh.load.store')->middleware(['can:admin-load-create']);
    Route::any('/edit-load-type/{id}', [LoadTypeController::class, 'edit'])->name('load.edit')->middleware(['can:admin-load-edit']);
    Route::any('/delete-load-type/{id}', [LoadTypeController::class, 'destroy'])->name('load.delete')->middleware(['can:admin-load-delete']);
    Route::any('/admin-load-type-list', [LoadTypeController::class, 'adminLoadList'])->name('back.load.list')->middleware(['can:admin-load-view']);




        //Ware House
    Route::any('/wh', [WareHouseController::class, 'index'])->name('wh.index')->middleware(['can:admin-wh-view']);
    Route::any('/wh-list', [WareHouseController::class, 'whList'])->name('wh.list')->middleware(['can:admin-wh-view']);
    Route::any('/wh-create', [WareHouseController::class, 'createWh'])->name('wh.create')->middleware(['can:admin-wh-create']);
    Route::any('/save-update-wh', [WareHouseController::class, 'whCreateOrUpdate'])->name('wh.store')->middleware(['can:admin-wh-create']);
    Route::any('/edit-wh/{id}', [WareHouseController::class, 'edit'])->name('wh.edit')->middleware(['can:admin-wh-edit']);
    Route::any('/delete-wh/{id}', [WareHouseController::class, 'destroy'])->name('wh.delete')->middleware(['can:admin-wh-delete']);
    Route::post('/wh-assign-fields', [WareHouseController::class, 'whAssignFields'])->name('wh.assign.fields')->middleware(['can:admin-wh-create']);
    Route::any('/get-door-wh-id/{id}', [WareHouseController::class, 'getDoorsByWhId'])->name('wh-doors.list')->middleware(['can:admin-load-view']);


    //Assign Fileds
    Route::get('/wh-assign-fields-list', [WareHouseController::class, 'whAssignFieldsList'])->name('wh.assign.fields.list')->middleware(['can:admin-wh-create']);
    Route::get('/edit-assigned-fields/{id}', [WareHouseController::class, 'editWhAssignFields'])->name('wh.assign.fields.edit')->middleware(['can:admin-wh-create']);
    Route::any('/delete-assigned-fields/{id}', [WareHouseController::class, 'destroyAssignedField'])->name('wh.assign.fields.delete');

    //customers

    Route::any('/customer', [CustomerController::class, 'index'])->name('customer.index')->middleware(['can:admin-customer-view']);
    Route::any('/customer-list', [CustomerController::class,'customerList'])->name('customer.list')->middleware(['can:admin-customer-view']);
    Route::any('/customer-create', [CustomerController::class, 'customerCreate'])->name('customer.create')->middleware(['can:admin-customer-create']);
    Route::any('/edit-customer/{id}', [CustomerController::class, 'edit'])->name('customer.edit')->middleware(['can:admin-load-edit']);
    Route::any('/delete-customer/{id}', [CustomerController::class, 'destroy'])->name('customer.delete')->middleware(['can:admin-customer-delete']);



    //Custom Fields
    Route::any('/custom-field', [CustomFieldController::class, 'index'])->name('customField.index')->middleware(['can:admin-custom_fields-view']);
    Route::any('/custom-field-list', [CustomFieldController::class, 'customFieldList'])->name('customField.List')->middleware(['can:admin-custom_fields-view']);
    Route::any('/custom-field-create', [CustomFieldController::class, 'customFieldCreate'])->name('customField.create')->middleware(['can:admin-custom_fields-create']);
    Route::any('/save-update-custom-field', [CustomFieldController::class, 'customFieldCreateOrUpdate'])->name('customField.store')->middleware(['can:admin-custom_fields-create']);
    Route::any('/edit-custom-field/{id}', [CustomFieldController::class, 'edit'])->name('customField.edit')->middleware(['can:admin-custom_fields-edit']);
    Route::any('/delete-custom-field/{id}', [CustomFieldController::class, 'destroy'])->name('customField.delete')->middleware(['can:admin-custom_fields-delete']);




    //Companies
    Route::any('/companies', [CompaniesController::class, 'index'])->name('companies.index')->middleware(['can:admin-companies-view']);
    Route::any('/companies-list', [CompaniesController::class, 'companiesList'])->name('companies.List')->middleware(['can:admin-companies-view']);
    Route::any('/companies-create', [CompaniesController::class, 'companiesCreate'])->name('companies.create')->middleware(['can:admin-companies-create']);
    Route::any('/save-update-companies', [CompaniesController::class, 'companiesCreateOrUpdate'])->name('companies.store')->middleware(['can:admin-companies-create']);
    Route::any('/edit-companies/{id}', [CompaniesController::class, 'edit'])->name('companies.edit')->middleware(['can:admin-companies-edit']);
    Route::any('/delete-companies/{id}', [CompaniesController::class, 'destroy'])->name('companies.delete')->middleware(['can:admin-companies-delete']);



//    carriers
    Route::get('/get-companies', [CarriersController::class,'getCompanies'])->name('get.companies');
    Route::any('/carriers', [CarriersController::class, 'index'])->name('carriers.index')->middleware(['can:admin-carriers-view']);
    Route::any('/carriers-list', [CarriersController::class, 'carriersList'])->name('carriers.List')->middleware(['can:admin-carriers-view']);
    Route::any('/carriers-create', [CarriersController::class, 'carriersCreate'])->name('carriers.create')->middleware(['can:admin-carriers-create']);
    Route::any('/save-update-carriers', [CarriersController::class, 'carriersCreateOrUpdate'])->name('carriers.store')->middleware(['can:admin-carriers-create']);
    Route::any('/edit-carriers/{id}', [CarriersController::class, 'edit'])->name('carriers.edit')->middleware(['can:admin-carriers-edit']);
    Route::any('/delete-carriers/{id}', [CarriersController::class, 'destroy'])->name('carriers.delete')->middleware(['can:admin-carriers-delete']);

    Route::any('/all-custom-fields', [CustomFieldController::class, 'allCustomFields'])->name('custom.field.list');

    //Dock
    Route::any('/dock-store', [DockController::class, 'storeDock'])->name('dock.store');
    Route::any('/wh-dock-list', [DockController::class, 'dockList'])->name('wh.dock.list');
    Route::any('/edit-dock/{id}', [DockController::class, 'editDock'])->name('dock.edit');
    Route::any('/delete-dock/{id}', [DockController::class, 'destroy'])->name('dock.delete');

    //Orders
    Route::any('/orders', [OrderController::class, 'index'])->name('orders.list')->middleware(['can:admin-order-view']);
    Route::any('/get-orders', [OrderController::class, 'getOrders'])->name('orders.all')->middleware(['can:admin-order-view']);
    Route::any('/create-order', [OrderController::class, 'createNewOrder'])->name('order.create')->middleware(['can:admin-order-view']);
    Route::any('/get-order-detail/{id}', [OrderController::class, 'getOrderDetail'])->name('orders.detail');
    Route::any('/get-order-info/{id}', [OrderController::class, 'getOrderInfo'])->name('orders.info');
    Route::any('/change-order-status/{orderId}/{orderStatus}', [OrderController::class, 'changeOrderStatus'])->name('change.order.status');
    Route::any('/undo-order-status/{orderId}', [OrderController::class, 'undoOrderStatus'])->name('undo.order.status');



        //Check In
        Route::any('/check-in', [CheckInController::class, 'index'])->name('check-in.index')->middleware(['can:admin-load-view']);
        Route::any('/check-in-list', [CheckInController::class, 'checkInList'])->name('check-in.list')->middleware(['can:admin-load-view']);
        Route::any('/save-update-check-in', [CheckInController::class, 'checkinCreateOrUpdate'])->name('checkin.store')->middleware(['can:admin-load-create']);

        //Order Contact
        Route::any('/order-contact-list', [OrderContactController::class, 'orderContactList'])->name('orderContact.list')->middleware(['can:admin-load-view']);

        //Off Loading
        Route::any('/off-loading', [OffLoadingController::class, 'index'])->name('off-loading.index')->middleware(['can:admin-load-view']);
        Route::any('/off-loading-list', [OffLoadingController::class, 'offLoadingList'])->name('off-loading.list')->middleware(['can:admin-load-view']);
        Route::any('/off-loading-detail/{id}', [OffLoadingController::class, 'offLoadingDetail'])->name('off-loading.detail')->middleware(['can:admin-load-view']);
        Route::any('/save-update-off-loading', [OffLoadingController::class, 'offLoadingCreateOrUpdate'])->name('off-loading.store')->middleware(['can:admin-load-create']);
        Route::any('/upload-images', [OffLoadingController::class, 'saveOffLoadingImages'])->name('off-loading.save.images');

        //Notifications
        Route::any('/trigger-notification', [OrderController::class, 'notificationTrigger']);


    });


    Route::get('/read-notification/{id}', [NotificationController::class, 'readNotification'])->name('notification.read');
    Route::get('/notification-list', [NotificationController::class, 'getUnreadNotifications'])->name('notification.unread');



    });


    Route::any('/get-wh-fields', [CustomFieldController::class, 'getWhFields'])->name('wh.fields');
    Route::get('/admin-logout', [HomeController::class, 'customLogout'])->name('admin.logout');
    Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login.view');
    Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');

    Route::get('/carrier-onboard/{id}', [CarriersController::class, 'carrierOnboard'])->name('carrier.onboard');
    Route::post('/save-carrier-info', [CarriersController::class, 'saveCarrierInfo'])->name('carrier.info.store');
    Route::post('/save-packaging-info', [OrderController::class, 'savePackagingInfo'])->name('packaging.info.store');
    Route::any('/save-packaging-images', [OrderController::class, 'savePackagingImages'])->name('packaging.images.store');
    Route::get('/check-order-id', [OrderController::class, 'checkOrderId'])->name('checkOrderId');



    Route::post('/verify-warehouse-id', [OrderController::class, 'verifyWarehouseId'])->name('verify.warehouse.id');

    Route::any('/get-wh-fields', [CustomFieldController::class, 'getWhFields'])->name('wh.fields');
    Route::get('/admin-logout', [HomeController::class, 'customLogout'])->name('admin.logout');
    Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login.view');
    Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
    Route::get('/carrier-onboard/{id}', [CarriersController::class, 'carrierOnboard'])->name('carrier.onboard');
    Route::post('/save-carrier-info', [CarriersController::class, 'saveCarrierInfo'])->name('carrier.info.store');
    Route::get('/check-order-id', [OrderController::class, 'checkOrderId'])->name('checkOrderId');
    Route::post('/verify-warehouse-id', [OrderController::class, 'verifyWarehouseId'])->name('verify.warehouse.id');




