<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SuperAdmin',
            'Admin',
            'Teacher',
            'Student',
            'Guardian',
            'Librarian',
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        $permissions = [
            'Show-Users',
            'Create-Users',
            'Edit-Users',
            'Delete-Users',
            'Role-Management',
            'Permissions-Management',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        if ($superAdminRole) {
            $allPermissions = Permission::pluck('id')->toArray();
            $superAdminRole->syncPermissions($allPermissions);
        }
    }
}
