<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $sucursalCentral = Sucursal::where('codigo', 'SUC-01')->first();
        $rolAdmin = Rol::where('slug', 'admin')->first();
        $rolAtencion = Rol::where('slug', 'personal_atencion')->first();
        $rolCajero = Rol::where('slug', 'cajero')->first();

        // 1. USUARIO ADMINISTRADOR GENERAL
        $admin = User::updateOrCreate(
            ['email' => 'admin@empresa.com'],
            [
                'nombres' => 'Administrador',
                'ap_paterno' => 'Sistema',
                'ap_materno' => 'General',
                'name' => 'Administrador Sistema',
                'cedula' => '1234567-LP',
                'direccion' => 'Av. Central 100',
                'celular' => '70000001',
                'password' => Hash::make('password'),
                'sucursal_id' => $sucursalCentral?->id,
                'rol_id' => $rolAdmin?->id,
                'activo' => true,
            ]
        );

        // 2. USUARIO PERSONAL DE ATENCIÓN
        $userAtencion = User::updateOrCreate(
            ['email' => 'atencion@empresa.com'],
            [
                'nombres' => 'Carlos',
                'ap_paterno' => 'Mendoza',
                'ap_materno' => 'Rios',
                'name' => 'Carlos Mendoza Rios',
                'cedula' => '2345678-LP',
                'direccion' => 'Calle 4 #200',
                'celular' => '70000002',
                'password' => Hash::make('password'),
                'sucursal_id' => $sucursalCentral?->id,
                'rol_id' => $rolAtencion?->id,
                'activo' => true,
            ]
        );

        // 3. USUARIO CAJERO / VENTANILLA
        $userCajero = User::updateOrCreate(
            ['email' => 'cajero@empresa.com'],
            [
                'nombres' => 'María',
                'ap_paterno' => 'Fernández',
                'ap_materno' => 'Vargas',
                'name' => 'María Fernández Vargas',
                'cedula' => '3456789-LP',
                'direccion' => 'Av. Bolivia #300',
                'celular' => '70000003',
                'password' => Hash::make('password'),
                'sucursal_id' => $sucursalCentral?->id,
                'rol_id' => $rolCajero?->id,
                'activo' => true,
            ]
        );

        // Asignar Permisos Específicos por Usuario
        $permisosAtencion = Permiso::whereIn('clave', [
            'reservas.ver',
            'reservas.crear',
            'reservas.modificar_estado',
            'atencion.registrar',
            'clientes.gestionar',
        ])->pluck('id');
        $userAtencion->permisos()->sync($permisosAtencion);

        $permisosCajero = Permiso::whereIn('clave', [
            'caja.gestionar',
            'caja.cobrar',
            'caja.movimientos',
            'reservas.ver',
        ])->pluck('id');
        $userCajero->permisos()->sync($permisosCajero);
    }
}
