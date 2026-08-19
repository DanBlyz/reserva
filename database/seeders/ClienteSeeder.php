<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombres' => 'Juan Pedro',
                'apellidos' => 'Pérez Gómez',
                'cedula' => '5432109-LP',
                'nit' => '5432109012',
                'fecha_nacimiento' => '1990-05-15',
                'direccion' => 'Zona Sopocachi #45',
                'celular' => '71112233',
                'correo' => 'juan.perez@cliente.com',
                'observaciones_generales' => 'Cliente preferencial',
            ],
            [
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Torres Morales',
                'cedula' => '6543210-CB',
                'nit' => '6543210015',
                'fecha_nacimiento' => '1995-09-20',
                'direccion' => 'Av. América #12',
                'celular' => '72223344',
                'correo' => 'ana.torres@cliente.com',
                'observaciones_generales' => 'Alergia a ciertos medicamentos',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::updateOrCreate(['cedula' => $cliente['cedula']], $cliente);
        }
    }
}
