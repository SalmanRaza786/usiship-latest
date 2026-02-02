<?php

namespace Database\Seeders;

use App\Models\CustomerCompany;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $company = CustomerCompany::updateOrCreate(
            ['email' =>'mait@gmail.com'],
            [
                'title' => 'MAIT',
                'email' => 'mait@gmail.com',
                'contact' =>'12345678',
                'address'=>'Test Address',
            ]);

        $user = User::updateOrCreate(
            ['email' =>'user@gmail.com'],
            [
                'company_id' => $company->id,
                'name' => 'Salman',
                'email' => 'user@gmail.com',
                'password' =>'iub12345678',
                'email_verified_at'=>'2022-01-02 17:04:58',
                'created_at' => now(),
            ]);
    }
}
