<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create Permissions
        Permission::firstOrCreate(['name' => 'access_settings']);
        Permission::firstOrCreate(['name' => 'manage_roles']);
        Permission::firstOrCreate(['name' => 'manage_academic_settings']);
        Permission::firstOrCreate(['name' => 'manage_institution_settings']);

        // Create Roles and Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'System Administrator']);
        $adminRole->givePermissionTo(Permission::all());

        Role::firstOrCreate(['name' => 'Secretary']);
        Role::firstOrCreate(['name' => 'Teacher']);
    }
}
