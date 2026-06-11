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
        // Crear permisos básicos
        $permissions = [
            'crear',
            'editar',
            'eliminar',
            'usuario',
            'administrador'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Obtener permisos para roles
        $allPermissions = Permission::all();
        $usuarioPermission = Permission::where('name', 'usuario')->first();
        $adminPermission = Permission::where('name', 'administrador')->first();

        // Crear roles
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $usuarioRole = Role::firstOrCreate(['name' => 'Usuario']);
        $cajeroRole = Role::firstOrCreate(['name' => 'Cajero']);

        // Asignar permisos a roles
        $superAdminRole->syncPermissions($allPermissions);
        $adminRole->syncPermissions([$adminPermission]);
        $usuarioRole->syncPermissions([$usuarioPermission]);
        $cajeroRole->syncPermissions([]); // Puedes definir permisos si es necesario

        // Crear usuarios y asignarles roles
        $userSuperAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'SuperAdmin',
                'password' => Hash::make('Admin21141998'),
                'role' => 1,
            ]
        );
        $userSuperAdmin->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456789'),
                'role' => 3,
            ]
        );
        $adminUser->assignRole($adminRole);

        $cajeroUser = User::firstOrCreate(
            ['email' => 'cajero@gmail.com'],
            [
                'name' => 'Cajero',
                'password' => Hash::make('123456789'),
                'role' => 3,
            ]
        );
        $cajeroUser->assignRole($cajeroRole);
    }
}
