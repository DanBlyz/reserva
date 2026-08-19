<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            PermisoSeeder::class,
            SucursalSeeder::class,
            ServicioSeeder::class,
            UserSeeder::class,
            ClienteSeeder::class,
        ]);
    }
}
