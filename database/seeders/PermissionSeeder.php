<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\PermissionModule;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $role_module = PermissionModule::updateOrCreate(['title' => 'Roles'], ['title' =>'Roles']);
        $user_module = PermissionModule::updateOrCreate(['title' => 'Users'], ['title' =>'Users']);
        $perm_module = PermissionModule::updateOrCreate(['title' => 'Permissions'], ['title' =>'Permissions']);
        $load_module = PermissionModule::updateOrCreate(['title' => 'Load Type'], ['title' =>'Load Type']);
        $wh_module = PermissionModule::updateOrCreate(['title' => 'Warehouse'], ['title' =>'Warehouse']);
        $customer_module = PermissionModule::updateOrCreate(['title' => 'Customer'], ['title' =>'Customer']);
        $custom_fields_module = PermissionModule::updateOrCreate(['title' => 'Custom Fields'], ['title' =>'Custom Fields']);
        $cumpanies_module = PermissionModule::updateOrCreate(['title' => 'Companies'], ['title' =>'Companies']);
        $carriers_module = PermissionModule::updateOrCreate(['title' => 'Carriers'], ['title' =>'Carriers']);
        $order = PermissionModule::updateOrCreate(['title' => 'Orders'], ['title' =>'Orders']);
        $notification = PermissionModule::updateOrCreate(['title' => 'Notifications'], ['title' =>'Notifications']);
        $CheckIn = PermissionModule::updateOrCreate(['title' => 'Check-In'], ['title' =>'Check-In']);
        $OffLoading = PermissionModule::updateOrCreate(['title' => 'Off Loading'], ['title' =>'Off Loading']);
        $itemPutAway = PermissionModule::updateOrCreate(['title' => 'Item Put Away'], ['title' =>'Item Put Away']);

        $notification_template = PermissionModule::updateOrCreate(['title' => 'Notification Template'], ['title' =>'Notification Template']);

        $misc_module = PermissionModule::updateOrCreate(['title' => 'Miscellaneous'], ['title' =>'Miscellaneous'] );

        Permission::upsert([


            //role
            ['name' => 'admin-role-view', 'module_id' =>$role_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-role-create', 'module_id' =>$role_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-role-edit', 'module_id' =>$role_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-role-delete', 'module_id' =>$role_module->id, 'guard_name' => 'admin'],

            //Users
            ['name' => 'admin-user-view', 'module_id' =>$user_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-user-create', 'module_id' =>$user_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-user-edit', 'module_id' =>$user_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-user-delete', 'module_id' =>$user_module->id, 'guard_name' => 'admin'],


            //Permissions
            ['name' => 'admin-permission-view', 'module_id' =>$perm_module->id, 'guard_name' => 'admin'],


            //Load Type
            ['name' => 'admin-load-view', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-create', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-edit', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-delete', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],

            //Load Type
            ['name' => 'admin-load-view', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-create', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-edit', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-load-delete', 'module_id' =>$load_module->id, 'guard_name' => 'admin'],

            //Ware House
            ['name' => 'admin-wh-view', 'module_id' =>$wh_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-wh-create', 'module_id' =>$wh_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-wh-edit', 'module_id' =>$wh_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-wh-delete', 'module_id' =>$wh_module->id, 'guard_name' => 'admin'],


            //customer
            ['name' => 'admin-customer-view', 'module_id' =>$customer_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-customer-create', 'module_id' =>$customer_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-customer-edit', 'module_id' =>$customer_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-customer-delete', 'module_id' =>$customer_module->id, 'guard_name' => 'admin'],

            //Custom Fields
            ['name' => 'admin-custom_fields-view', 'module_id' =>$custom_fields_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-custom_fields-create', 'module_id' =>$custom_fields_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-custom_fields-edit', 'module_id' =>$custom_fields_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-custom_fields-delete', 'module_id' =>$custom_fields_module->id, 'guard_name' => 'admin'],

            //Companies
            ['name' => 'admin-companies-view', 'module_id' =>$cumpanies_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-companies-create', 'module_id' =>$cumpanies_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-companies-edit', 'module_id' =>$cumpanies_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-companies-delete', 'module_id' =>$cumpanies_module->id, 'guard_name' => 'admin'],

            //Carriers
            ['name' => 'admin-carriers-view', 'module_id' =>$carriers_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-carriers-create', 'module_id' =>$carriers_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-carriers-edit', 'module_id' =>$carriers_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-carriers-delete', 'module_id' =>$carriers_module->id, 'guard_name' => 'admin'],



            //Orders
            ['name' => 'admin-order-view', 'module_id' =>$order->id, 'guard_name' => 'admin'],

            //Notifications
            ['name' => 'admin-notification-view', 'module_id' =>$notification->id, 'guard_name' => 'admin'],

            //Checkin Away
            ['name' => 'admin-checkin-view', 'module_id' =>$CheckIn->id, 'guard_name' => 'admin'],
            ['name' => 'admin-checkin-create', 'module_id' =>$CheckIn->id, 'guard_name' => 'admin'],
            ['name' => 'admin-checkin-edit', 'module_id' =>$CheckIn->id, 'guard_name' => 'admin'],
            ['name' => 'admin-checkin-delete', 'module_id' =>$CheckIn->id, 'guard_name' => 'admin'],

            //Off Loading Away
            ['name' => 'admin-offloading-view', 'module_id' =>$OffLoading->id, 'guard_name' => 'admin'],
            ['name' => 'admin-offloading-create', 'module_id' =>$OffLoading->id, 'guard_name' => 'admin'],
            ['name' => 'admin-offloading-edit', 'module_id' =>$OffLoading->id, 'guard_name' => 'admin'],
            ['name' => 'admin-offloading-delete', 'module_id' =>$OffLoading->id, 'guard_name' => 'admin'],

            //Item Put Away
            ['name' => 'admin-putaway-view', 'module_id' =>$itemPutAway->id, 'guard_name' => 'admin'],
            ['name' => 'admin-putaway-create', 'module_id' =>$itemPutAway->id, 'guard_name' => 'admin'],
            ['name' => 'admin-putaway-edit', 'module_id' =>$itemPutAway->id, 'guard_name' => 'admin'],
            ['name' => 'admin-putaway-delete', 'module_id' =>$itemPutAway->id, 'guard_name' => 'admin'],

            //Notifications Templates
            ['name' => 'admin-notification-template-view', 'module_id' =>$notification_template->id, 'guard_name' => 'admin'],
            ['name' => 'admin-notification-template-create', 'module_id' =>$notification_template->id, 'guard_name' => 'admin'],



            //Miscellaneous
            ['name' => 'admin-settings-edit', 'module_id' =>$misc_module->id, 'guard_name' => 'admin'],
            ['name' => 'admin-dashboard-view', 'module_id' =>$misc_module->id, 'guard_name' => 'admin'],



        ], ['name']);

    }
}
