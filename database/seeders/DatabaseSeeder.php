<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
//        $this->call(mnt_rol::class);
//        $this->call(permissions::class);

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@salud.gob.sv',
            'password' => bcrypt('admin'),
         ]);

        //creando permisos
        Permission::create(['name' => 'PERMISSION_USER_CREATE']);
        Permission::create(['name' => 'PERMISSION_USER_UPDATE']);
        Permission::create(['name' => 'PERMISSION_USER_DELETE']);
        Permission::create(['name' => 'PERMISSION_USER_LIST']);
        Permission::create(['name' => 'PERMISSION_USER_SHOW']);
        Permission::create(['name' => 'PERMISSION_USER_PASSWORD_UPDATE']);
        Permission::create(['name' => 'PERMISSION_LISTAR_PRODUCTOS']);


        // create roles and assign existing permissions
        $superAdmin = Role::create(['name' => 'SUPER_ADMIN']);
        $roleAdmin = Role::create(['name' => 'ROLE_ADMIN']);
        $roleUser = Role::create(['name' => 'ROLE_USER']);
        $rolVendor = Role::create(['name' => 'ROLE_VENDEDOR']);

        $superAdmin->givePermissionTo('PERMISSION_USER_CREATE');
        $superAdmin->givePermissionTo('PERMISSION_USER_UPDATE');
        $superAdmin->givePermissionTo('PERMISSION_USER_DELETE');
        $superAdmin->givePermissionTo('PERMISSION_USER_LIST');
        $superAdmin->givePermissionTo('PERMISSION_USER_SHOW');
        $superAdmin->givePermissionTo('PERMISSION_USER_PASSWORD_UPDATE');
        $superAdmin->givePermissionTo('PERMISSION_LISTAR_PRODUCTOS');
        $user->assignRole($superAdmin);

        $roleAdmin->givePermissionTo('PERMISSION_USER_CREATE');
        $roleAdmin->givePermissionTo('PERMISSION_USER_UPDATE');
        $roleAdmin->givePermissionTo('PERMISSION_USER_LIST');
        $roleAdmin->givePermissionTo('PERMISSION_USER_SHOW');

        $roleUser->givePermissionTo('PERMISSION_USER_PASSWORD_UPDATE');

        $rolVendor->givePermissionTo('PERMISSION_LISTAR_PRODUCTOS');
        $user->assignRole($rolVendor);
        
    }
}
