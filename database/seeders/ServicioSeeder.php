<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            [
                'nombre' => 'Consulta Especializada',
                'descripcion' => 'Atención inicial y diagnóstico general',
                'precio_base' => 150.00,
                'duracion_minutos' => 30,
                'color' => '#4f46e5',
                'activo' => true,
            ],
            [
                'nombre' => 'Tratamiento Integral',
                'descripcion' => 'Procedimiento completo de atención personalizada',
                'precio_base' => 300.00,
                'duracion_minutos' => 60,
                'color' => '#059669',
                'activo' => true,
            ],
            [
                'nombre' => 'Revisión y Control',
                'descripcion' => 'Seguimiento a tratamientos o consultas previas',
                'precio_base' => 80.00,
                'duracion_minutos' => 20,
                'color' => '#d97706',
                'activo' => true,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::updateOrCreate(['nombre' => $servicio['nombre']], $servicio);
        }
    }
}
