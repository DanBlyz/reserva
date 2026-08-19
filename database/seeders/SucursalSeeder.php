<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        $sucursales = [
            [
                'nombre' => 'Sucursal Central',
                'codigo' => 'SUC-01',
                'direccion' => 'Av. Principal #123, Zona Central',
                'telefono' => '71234567',
                'ciudad' => 'La Paz',
                'activa' => true,
            ],
            [
                'nombre' => 'Sucursal Norte',
                'codigo' => 'SUC-02',
                'direccion' => 'Calle Comercial #456, Zona Norte',
                'telefono' => '77654321',
                'ciudad' => 'Cochabamba',
                'activa' => true,
            ],
            [
                'nombre' => 'Sucursal Sur',
                'codigo' => 'SUC-03',
                'direccion' => 'Av. San Martín #789, Equipetrol',
                'telefono' => '78901234',
                'ciudad' => 'Santa Cruz',
                'activa' => true,
            ],
        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::updateOrCreate(['codigo' => $sucursal['codigo']], $sucursal);
        }
    }
}
