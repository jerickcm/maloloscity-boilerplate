<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
// use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Super Admin */
        $user = User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@maloloscity.gov.ph',
            'is_admin' => 1,
            'password' =>  Hash::make(config('custom.password_superadmin'))
        ]);
        $user->assignRole('ADMIN');
        $user->assignRole('SUPERADMIN');

        /** Permissions ALL */

        /** Page Access */
        $user->givePermissionTo('Access-Page-User');
        $user->givePermissionTo('Access-Page-Dashboard');
        $user->givePermissionTo('Access-Page-Logs');

        /** Page Actions */
        $user->givePermissionTo('Action Edit Permission');

        /* User Permission */
        $user->givePermissionTo('Action Delete User');
        $user->givePermissionTo('Action Create User');
        $user->givePermissionTo('Action Edit User');
        $user->givePermissionTo('Action Show-All User');

        /* Logs Permission */

        /* Admin and SuperAdmin Permission */
        $user->givePermissionTo('Action Settings Roles');
        $user->givePermissionTo('');
        $user->givePermissionTo('Action Download User');
        $user->givePermissionTo('Action Download Logs');


        /* Admin */
        $user = User::create([
            'name' => 'Admin Account',
            'email' => 'admin@maloloscity.gov.ph',
            'is_admin' => 1,
            'password' =>  Hash::make(config('custom.password_admin'))
        ]);

        $user->assignRole('ADMIN');

        /** Page Access */
        $user->givePermissionTo('Access-Page-User');
        $user->givePermissionTo('Access-Page-Dashboard');
        $user->givePermissionTo('Access-Page-Logs');

        /** Page Actions */
        $user->givePermissionTo('Action Edit Permission');
        /* User Permission */
        $user->givePermissionTo('Action Delete User');
        $user->givePermissionTo('Action Create User');
        $user->givePermissionTo('Action Edit User');
        $user->givePermissionTo('Action Show-All User');

        /* Logs Permission */

        /* Admin and SuperAdmin Permission */
        $user->givePermissionTo('Action Settings Roles');
        $user->givePermissionTo('Action Download User');
        $user->givePermissionTo('Action Download Logs');

        /* Admin */
        $user = User::create([
            'name' => 'Director Account',
            'email' => 'director@maloloscity.gov.ph',
            'is_admin' => 1,
            'password' =>  Hash::make(config('custom.password_admin'))
        ]);

        $user->assignRole('ADMIN');

        /** Page Access */
        $user->givePermissionTo('Access-Page-User');
        $user->givePermissionTo('Access-Page-Dashboard');
        $user->givePermissionTo('Access-Page-Logs');
        /** Page Actions */
        $user->givePermissionTo('Action Edit Permission');
        /* User Permission */
        $user->givePermissionTo('Action Delete User');
        $user->givePermissionTo('Action Create User');
        $user->givePermissionTo('Action Edit User');
        $user->givePermissionTo('Action Show-All User');

        /* Logs Permission */

        $lists = [
            ['email' => 'user1@maloloscity.gov.ph', 'name' => 'user1', 'password' => 'malolos123'],
            ['email' => 'user2@maloloscity.gov.ph', 'name' => 'user2', 'password' => 'malolos123'],
            ['email' => 'user3@maloloscity.gov.ph', 'name' => 'user3', 'password' => 'malolos123'],
            ['email' => 'user4@maloloscity.gov.ph', 'name' => 'user4', 'password' => 'malolos123'],
            ['email' => 'user5@maloloscity.gov.ph', 'name' => 'user5', 'password' => 'malolos123'],
        ];

        foreach ($lists as $list) {

            $user = User::create([
                'name' => $list['name'],
                'email' =>  $list['email'],
                'is_admin' => 0,
                'password' =>  Hash::make($list['password'],)
            ]);

            $user->assignRole('USER');

            /** Page Access */
            $user->givePermissionTo('Access-Page-User');
            $user->givePermissionTo('Access-Page-Dashboard');

            /* User Permission */
            $user->givePermissionTo('Action Edit User');
        }
    }
}
