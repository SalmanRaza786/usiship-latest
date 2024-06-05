<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(['name' =>'Admin'],['name' =>'Admin','guard_name'=>'admin','status'=>1,'created_at'=>now()]);
        $user = Admin::updateOrCreate(
            ['email' =>'admin@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' =>Hash::make('iub12345678'),
                'created_at' => now(),
                'role_id' =>$role->id,
            ]);
        $user->syncRoles($role->id);

        $permissions= Permission::pluck('id');
        $role->syncPermissions($permissions);

    }
}
