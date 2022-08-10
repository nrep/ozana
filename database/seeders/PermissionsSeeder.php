<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'create stock items']);
        Permission::create(['name' => 'edit stock items']);
        Permission::create(['name' => 'view stock items']);
        Permission::create(['name' => 'delete stock items']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'delete orders']);
        Permission::create(['name' => 'view purchases and expenses report']);
        Permission::create(['name' => 'view sales and income report']);
        Permission::create(['name' => 'view income vs expenses report']);
        Permission::create(['name' => 'view expiry report']);
        Permission::create(['name' => 'view stock value report']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'pharmacist'])
            ->givePermissionTo([
                'create products',
                'edit products',
                'delete products',
                'view products',
                'view stock items',
                'create orders',
                'edit orders',
                'view orders',
                'delete orders',
                'view expiry report',
            ]);

        $pharmacist = User::factory()->create([
            'first_name' => 'Pharmacist',
            'email' => 'pharmacist@hosanna.com',
            'password' => Hash::make('12345678'),
        ]);

        $pharmacist->assignRole($role);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $admin = User::find(1);

        $admin->assignRole($role);
    }
}
