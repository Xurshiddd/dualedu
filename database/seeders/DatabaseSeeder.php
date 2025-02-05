<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'phone' => '+998975413303',
            'password' => bcrypt('123456'),
            'is_student' => false,
        ]);
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);
        // Create permissions
        $editPermission = Permission::create(['name' => 'edit articles']);
        $viewPermission = Permission::create(['name' => 'view articles']);
        $userPermission = Permission::create(['name' => 'users']);
        $adminRole->givePermissionTo($editPermission, $viewPermission);
        $userRole->givePermissionTo($userPermission);
        $user = User::find(1);
        $user->assignRole('Admin');
        for ($i = 0; $i<50; $i++) {
            $s = User::factory()->create();
            $s->assignRole('User');
        }
    }
}
