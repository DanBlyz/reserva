<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Módulo Sucursales
            ['nombre' => 'Ver Sucursales', 'clave' => 'sucursales.ver', 'modulo' => 'sucursales', 'descripcion' => 'Permite ver el listado de sucursales'],
            ['nombre' => 'Crear / Editar Sucursal', 'clave' => 'sucursales.gestionar', 'modulo' => 'sucursales', 'descripcion' => 'Permite crear o modificar datos de sucursales'],

            // Módulo Roles y Permisos
            ['nombre' => 'Ver Roles', 'clave' => 'roles.ver', 'modulo' => 'roles', 'descripcion' => 'Permite ver el listado de roles del sistema'],
            ['nombre' => 'Crear y Editar Roles', 'clave' => 'roles.gestionar', 'modulo' => 'roles', 'descripcion' => 'Permite crear o modificar roles'],

            // Módulo Usuarios y Permisos
            ['nombre' => 'Ver Usuarios', 'clave' => 'usuarios.ver', 'modulo' => 'usuarios', 'descripcion' => 'Permite listar los usuarios del personal'],
            ['nombre' => 'Crear y Editar Usuarios', 'clave' => 'usuarios.gestionar', 'modulo' => 'usuarios', 'descripcion' => 'Permite registrar y editar usuarios del personal'],
            ['nombre' => 'Gestionar Permisos de Usuario', 'clave' => 'usuarios.permisos', 'modulo' => 'usuarios', 'descripcion' => 'Permite asignar/quitar permisos individuales a usuarios'],

            // Módulo Servicios
            ['nombre' => 'Ver Servicios', 'clave' => 'servicios.ver', 'modulo' => 'servicios', 'descripcion' => 'Permite ver el catálogo de servicios'],
            ['nombre' => 'Gestionar Servicios', 'clave' => 'servicios.gestionar', 'modulo' => 'servicios', 'descripcion' => 'Permite crear, editar o eliminar servicios'],

            // Módulo Clientes
            ['nombre' => 'Ver Historial Completo de Clientes', 'clave' => 'clientes.ver_todo', 'modulo' => 'clientes', 'descripcion' => 'Permite consultar el historial de clientes de todas las sucursales'],
            ['nombre' => 'Crear y Editar Clientes', 'clave' => 'clientes.gestionar', 'modulo' => 'clientes', 'descripcion' => 'Permite registrar y actualizar información de clientes'],

            // Módulo Reservas
            ['nombre' => 'Ver Agenda de Reservas', 'clave' => 'reservas.ver', 'modulo' => 'reservas', 'descripcion' => 'Permite ver la agenda de citas'],
            ['nombre' => 'Crear Reservas', 'clave' => 'reservas.crear', 'modulo' => 'reservas', 'descripcion' => 'Permite agendar reservas a clientes asignando horario y personal'],
            ['nombre' => 'Cancelar / Reprogramar Reserva', 'clave' => 'reservas.modificar_estado', 'modulo' => 'reservas', 'descripcion' => 'Permite cancelar o reprogramar reservas registrando motivo'],

            // Módulo Atención de Clientes
            ['nombre' => 'Registrar Ficha de Atención', 'clave' => 'atencion.registrar', 'modulo' => 'atencion', 'descripcion' => 'Permite llenar el diagnóstico, cobros extras y recomendaciones del cliente'],

            // Módulo Cajas y Cobros en Ventanilla
            ['nombre' => 'Apertura y Cierre de Caja', 'clave' => 'caja.gestionar', 'modulo' => 'caja', 'descripcion' => 'Permite abrir y cerrar caja en la sucursal'],
            ['nombre' => 'Realizar Cobros y Emitir Recibos', 'clave' => 'caja.cobrar', 'modulo' => 'caja', 'descripcion' => 'Permite realizar el cobro final en ventanilla y emitir recibos'],
            ['nombre' => 'Registrar Movimientos de Caja', 'clave' => 'caja.movimientos', 'modulo' => 'caja', 'descripcion' => 'Permite registrar egresos e ingresos varios en caja'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(['clave' => $permiso['clave']], $permiso);
        }
    }
}
