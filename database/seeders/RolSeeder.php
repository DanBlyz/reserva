<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador General',
                'slug' => 'admin',
                'descripcion' => 'Acceso completo e ilimitado a todas las sucursales y configuraciones del sistema',
            ],
            [
                'nombre' => 'Personal de Atención',
                'slug' => 'personal_atencion',
                'descripcion' => 'Atiende citas de clientes, registra diagnósticos y observaciones de atención',
            ],
            [
                'nombre' => 'Cajero / Ventanilla',
                'slug' => 'cajero',
                'descripcion' => 'Abre/cierra caja, registra ingresos/egresos y realiza el cobro final emitiendo recibos',
            ],
            [
                'nombre' => 'Recepcionista',
                'slug' => 'recepcionista',
                'descripcion' => 'Registra clientes, agendan citas y gestiona la disponibilidad en sucursal',
            ],
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(['slug' => $rol['slug']], $rol);
        }
    }
}
