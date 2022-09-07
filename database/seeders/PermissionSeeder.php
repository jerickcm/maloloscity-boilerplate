<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
// use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Page Access */
        Permission::create(['name' => 'Access-Page-User']);
        Permission::create(['name' => 'Access-Page-Dashboard']);
        Permission::create(['name' => 'Access-Page-Logs']);

        /** Page Actions */
        Permission::create(['name' => 'Action Edit Permission']);

        /* User Permission */
        Permission::create(['name' => 'Action Delete User']);
        Permission::create(['name' => 'Action Create User']);
        Permission::create(['name' => 'Action Edit User']);
        Permission::create(['name' => 'Action Show-All User']);

        /* Logs Permission */

        Permission::create(['name' => 'Action Download User']);
        Permission::create(['name' => 'Action Download Logs']);
        Permission::create(['name' => 'Action Settings Roles']);

    }
}
