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
        Permission::firstOrCreate(['name' => 'view_conflicts']);
        Permission::firstOrCreate(['name' => 'view_reports']);

        // Create Roles and Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'System Administrator']);
        $adminRole->givePermissionTo(Permission::all());
        
        $adminRole = Role::firstOrCreate(['name' => 'System Administrator']);
        $adminRole->givePermissionTo(['view_conflicts', 'view_reports']);

        Role::firstOrCreate(['name' => 'Secretary']);
        Role::firstOrCreate(['name' => 'Teacher']);
    }
}
