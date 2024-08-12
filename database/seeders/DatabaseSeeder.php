<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AppSettingsTableSeeders::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(OperationalHoursSeeder::class);
        $this->call(LoadTypeSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(OrderNotificationContant::class);
        $this->call(CompanySeeder::class);
        $this->call(WhDoorSeeder::class);
        $this->call(WhLocationSeeder::class);
        $this->call(WorkOrderSeeder::class);
    }
}
