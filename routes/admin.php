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

use App\Http\Controllers\Admin\PackagingListController;

use App\Http\Controllers\Admin\PutAwayController;
use App\Http\Controllers\Admin\MediaController;

use App\Http\Controllers\Outbounds\WorkOrderController;
use App\Http\Controllers\Outbounds\PickingController;
use App\Http\Controllers\Outbounds\MissingController;
use App\Http\Controllers\Outbounds\QcController;
use App\Http\Controllers\Admin\CustomerCompanyController;







//Auth::routes();

    Auth::routes(['verify' => true]);


    Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {



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

    //carriers
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

        //Transactions
        Route::any('/transactions', [OrderController::class, 'transactionIndex'])->name('transactions.index')->middleware(['can:admin-order-view']);
        Route::any('/transactions-list', [OrderController::class, 'transactionsList'])->name('transactions.list');

        //Check In
        Route::any('/check-in', [CheckInController::class, 'index'])->name('check-in.index')->middleware(['can:admin-checkin-view']);
        Route::any('/checkin-view/{id}', [CheckInController::class, 'checkinView'])->name('checkin.view');
        Route::any('/check-in-list', [CheckInController::class, 'checkInList'])->name('check-in.list')->middleware(['can:admin-checkin-view']);
        Route::any('/save-update-check-in', [CheckInController::class, 'checkinCreateOrUpdate'])->name('checkin.store')->middleware(['can:admin-checkin-create']);
        Route::any('/close-arrival-notification/{id}', [CheckInController::class, 'closeArrivalNotification']);
        Route::any('/get-checkin-container/{id}', [CheckInController::class, 'findCheckIn']);


        //Order Contact
        Route::any('/order-contact-list', [OrderContactController::class, 'orderContactList'])->name('orderContact.list')->middleware(['can:admin-load-view']);
        Route::any('/get-order-contact', [OrderContactController::class, 'getOrderContact'])->name('orderContact.get')->middleware(['can:admin-load-view']);
        Route::any('/order-contact.update', [OrderContactController::class, 'updateOrderContact'])->name('orderContact.update')->middleware(['can:admin-load-view']);
        Route::any('/verify-carrier/{id}', [OrderContactController::class, 'verifyCarrier'])->name('carrier.verify')->middleware(['can:admin-load-view']);

        //Off Loading
        Route::any('/off-loading', [OffLoadingController::class, 'index'])->name('off-loading.index')->middleware(['can:admin-offloading-view']);
        Route::any('/off-loading-list', [OffLoadingController::class, 'offLoadingList'])->name('off-loading.list')->middleware(['can:admin-offloading-view']);
        Route::any('/off-loading-detail/{id}', [OffLoadingController::class, 'offLoadingDetail'])->name('off-loading.detail')->middleware(['can:admin-offloading-view']);
        Route::any('/save-update-off-loading', [OffLoadingController::class, 'offLoadingCreateOrUpdate'])->name('off-loading.store')->middleware(['can:admin-offloading-create']);
        Route::any('/update-off-loading', [OffLoadingController::class, 'offLoadingUpdate'])->name('off-loading.close')->middleware(['can:admin-offloading-create']);
        Route::any('/off-loading-upload-images', [OffLoadingController::class, 'saveOffLoadingImages'])->name('off-loading.save.images')->middleware(['can:admin-offloading-create']);

        Route::any('/check-order-checkin-id', [OffLoadingController::class, 'checkOrderCheckInId'])->name('off-loading.check.checkin.id');
        Route::any('/packaging-list-confirm/{id}', [OffLoadingController::class, 'packagingListConfirmation'])->name('off-loading.confirm.packaging.list');
        Route::any('/offloading-status-change/{id}', [OffLoadingController::class, 'offloadingStatusChange'])->name('offloading.status.change');
        Route::any('/update-packaging-list', [PackagingListController::class, 'updatePackagingList'])->name('update.packaging.list');




        //Item Put Away
        Route::any('/put-away', [PutAwayController::class, 'index'])->name('put-away.index')->middleware(['can:admin-putaway-view']);
        Route::any('/put-away-list', [PutAwayController::class, 'putAwayList'])->name('put-away.list')->middleware(['can:admin-load-view']);
        Route::any('/create-put-away/{id}', [PutAwayController::class, 'createPutAway'])->name('put-away.create')->middleware(['can:admin-putaway-view']);
        Route::any('/store-put-away', [PutAwayController::class, 'storePutAway'])->name('put-away.store')->middleware(['can:admin-putaway-create']);
        Route::get('/delete-putaway-item/{id}', [PutAwayController::class, 'deletePutAwayItem'])->name('put-away.delete')->middleware(['can:admin-putaway-delete']);
        Route::get('/check-putaway-status/{offloadingId}/{orderId}', [PutAwayController::class, 'checkPutAwayStatus'])->name('put-away.status')->middleware(['can:admin-putaway-create']);
        Route::get('/export-order-items/{orderId}', [PutAwayController::class, 'export'])->name('put-away.export')->middleware(['can:admin-putaway-create']);

        //Notificationss
        Route::any('/trigger-notification/{type}/{totifiableId}', [OrderController::class, 'notificationTrigger']);

        //Notifications Template
        Route::any('/templates', [NotificationController::class, 'index'])->name('notification.index')->middleware(['can:admin-notification-template-view']);
        Route::any('/create-template', [NotificationController::class, 'createTemplate'])->name('notification.create')->middleware(['can:admin-notification-template-create']);
        Route::any('/store-template', [NotificationController::class, 'storeTemplate'])->name('notification.store')->middleware(['can:admin-notification-template-create']);

        //Media Controller
        Route::any('/delete-media/{id}', [MediaController::class, 'deleteMedia'])->name('delete.media');



        //Outbounds
        Route::any('/work-orders', [WorkOrderController::class, 'workOrders'])->name('work.orders.index')->middleware(['can:admin-w-order-view']);
        Route::any('/work-orders-list', [WorkOrderController::class, 'workOrdersList'])->name('work.orders.list')->middleware(['can:admin-w-order-view']);
        Route::any('/picker-assign', [WorkOrderController::class, 'pickerAssign'])->name('picker.assign')->middleware(['can:admin-w-order-view']);

        //Picking
        Route::any('/picking', [PickingController::class, 'index'])->name('picking.index')->middleware(['can:admin-picking-view']);
        Route::any('/picker-list', [PickingController::class, 'pickerList'])->name('picker.list')->middleware(['can:admin-picking-view']);
        Route::any('/picking-detail/{id}', [PickingController::class, 'pickingDetail'])->name('picking.start')->middleware(['can:admin-picking-view']);
        Route::any('/update-start-picking', [PickingController::class, 'updateStartPicking'])->name('picking.update')->middleware(['can:admin-picking-create']);
        Route::any('/save-picked-items', [PickingController::class, 'savePickedItems'])->name('save-picked.items')->middleware(['can:admin-w-order-create']);

        //File
        Route::any('/file-remove', [PickingController::class, 'fileRemove'])->name('file.remove');

        //Missing
        Route::any('/missing', [MissingController::class, 'index'])->name('missing.index')->middleware(['can:admin-missing-view']);
        Route::any('/missing-list', [MissingController::class, 'missedList'])->name('missing.list')->middleware(['can:admin-missing-view']);
        Route::any('/missing-detail/{id}', [MissingController::class, 'missedDetail'])->name('missing.detail')->middleware(['can:admin-missing-view']);
        Route::any('/update-start-resolve', [MissingController::class, 'updateStartResolve'])->name('missed.update')->middleware(['can:admin-missing-create']);
        Route::any('/save-resolve', [MissingController::class, 'saveResolve'])->name('save.resolve')->middleware(['can:admin-missing-create']);


        //QC
        Route::any('/qc', [QcController::class, 'index'])->name('qc.index')->middleware(['can:admin-qc-view']);
        Route::any('/qc-list', [QcController::class, 'QcList'])->name('qc.list')->middleware(['can:admin-qc-view']);
        Route::any('/qc-detail/{id}', [QcController::class, 'qcDetail'])->name('qc.detail')->middleware(['can:admin-qc-view']);
        Route::any('/update-start-qc', [QcController::class, 'updateStartQc'])->name('qc.start')->middleware(['can:admin-qc-create']);
        Route::any('/save-qc', [QcController::class, 'saveQc'])->name('save.qc')->middleware(['can:admin-qc-create']);
        Route::any('/update-qc', [QcController::class, 'updateQcItem'])->name('update.qc')->middleware(['can:admin-qc-create']);

        //Customer-Companies
        Route::any('/customer-companies', [CustomerCompanyController::class, 'index'])->name('customer-companies.index')->middleware(['can:admin-customer-companies-view']);
        Route::any('/customer-companies-list', [CustomerCompanyController::class, 'companiesList'])->name('customer-companies.List')->middleware(['can:admin-customer-companies-view']);
        Route::any('/customer-companies-create', [CustomerCompanyController::class, 'companiesCreate'])->name('customer-companies.create')->middleware(['can:admin-customer-companies-create']);
        Route::any('/save-update-customer-companies', [CustomerCompanyController::class, 'companiesCreateOrUpdate'])->name('customer-companies.store')->middleware(['can:admin-customer-companies-create']);
        Route::any('/edit-customer-companies/{id}', [CustomerCompanyController::class, 'edit'])->name('customer-companies.edit')->middleware(['can:admin-customer-companies-edit']);
        Route::any('/delete-customer-companies/{id}', [CustomerCompanyController::class, 'destroy'])->name('customer-companies.delete')->middleware(['can:admin-customer-companies-delete']);




    });


    Route::get('/read-notification/{id}', [NotificationController::class, 'readNotification'])->name('notification.read');
    Route::get('/notification-list', [NotificationController::class, 'getUnreadNotifications'])->name('notification.unread');



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
    Route::get('/check-order-id', [OrderController::class, 'checkOrderId'])->name('checkOrderId');
    Route::post('/verify-warehouse-id', [OrderController::class, 'verifyWarehouseId'])->name('verify.warehouse.id');




