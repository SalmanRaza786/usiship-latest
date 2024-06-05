<?php

namespace Database\Seeders;

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

        $user = User::updateOrCreate(
            ['email' =>'user@gmail.com'],
            [
                'name' => 'Salman',
                'email' => 'user@gmail.com',
                'password' =>'iub12345678',
                'email_verified_at'=>'2022-01-02 17:04:58',
                'created_at' => now(),
            ]);
    }
}
