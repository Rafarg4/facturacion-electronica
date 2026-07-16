<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permisos por sección del sistema
        $permissions = [
            'inventario',
            'ventas',
            'caja',
            'reportes',
            'planes',
            'configuracion',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $desarrolladorRole = Role::firstOrCreate(['name' => 'Desarrollador']);
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $cajeroRole = Role::firstOrCreate(['name' => 'Cajero']);

        // Desarrollador: acceso total al sistema
        $desarrolladorRole->syncPermissions($permissions);

        // Administrador: todo el sistema menos Configuración
        $adminRole->syncPermissions(['inventario', 'ventas', 'caja', 'reportes', 'planes']);

        // Cajero: únicamente lo relacionado a Caja
        $cajeroRole->syncPermissions(['caja']);

        // Usuarios de ejemplo
        $desarrolladorUser = User::firstOrCreate(
            ['email' => 'desarrollador@gmail.com'],
            [
                'name' => 'Desarrollador',
                'password' => Hash::make('123456789'),
                'role' => 3,
                'caja' => 1,
            ]
        );
        $desarrolladorUser->syncRoles([$desarrolladorRole]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456789'),
                'role' => 3,
                'caja' => 1,
            ]
        );
        $adminUser->syncRoles([$adminRole]);

        $cajeroUser = User::firstOrCreate(
            ['email' => 'cajero@gmail.com'],
            [
                'name' => 'Cajero',
                'password' => Hash::make('123456789'),
                'role' => 3,
                'caja' => 1,
            ]
        );
        $cajeroUser->syncRoles([$cajeroRole]);
    }
}
