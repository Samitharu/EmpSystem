<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            'view home',
            'view settings',
            'update settings',
            'create employee',
            'view employee',
            'edit employee',
            'delete employee',
            // Add other permissions as needed
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'admin',
            'HR manager',
            'employee'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign all permissions to admin and HR manager roles
        $adminRole = Role::findByName('admin');
        $hrManagerRole = Role::findByName('HR manager');

        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions); // Use syncPermissions to avoid duplicates
        $hrManagerRole->syncPermissions($allPermissions);

        // Assign specific permissions to the employee role
        $employeeRole = Role::findByName('employee');
        $employeePermissions = [
            'view home',
            'view settings',
            'update settings',
        ];
        
        $employeeRole->syncPermissions($employeePermissions); // Use syncPermissions to avoid duplicates
    }
}
