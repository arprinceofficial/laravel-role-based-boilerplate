<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view',
            'edit',
            'delete',
        ];

        foreach ($permissions as $perm) {
            DB::table('permissions')->insert([
                'name' => $perm,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assign permissions to a role.
        $adminRole = Role::where('name', 'Admin')->first();
        $adminRole->permissions()->attach(Permission::all());

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdminRole->permissions()->attach(Permission::all());
    }
}
