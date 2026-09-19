<?php

use App\Livewire\Components\SucursalSelector;
use App\Livewire\Servicios\ServiciosIndex;
use App\Models\Rol;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    // Asegurar roles y sucursales base
    $this->adminRole = Rol::firstOrCreate(
        ['slug' => 'admin'],
        ['nombre' => 'Administrador General', 'descripcion' => 'Acceso total']
    );

    $this->sucursal1 = Sucursal::firstOrCreate(
        ['codigo' => 'SUC-01'],
        ['nombre' => 'Sucursal Central', 'activa' => true]
    );

    $this->sucursal2 = Sucursal::firstOrCreate(
        ['codigo' => 'SUC-02'],
        ['nombre' => 'Sucursal Norte', 'activa' => true]
    );

    $this->adminUser = User::factory()->create([
        'rol_id' => $this->adminRole->id,
        'sucursal_id' => $this->sucursal1->id,
        'activo' => true,
    ]);
});

test('los usuarios no autenticados son redirigidos al login al intentar ver servicios', function () {
    $response = $this->get('/servicios');

    $response->assertRedirect('/login');
});

test('un usuario autenticado puede acceder a la ruta de servicios', function () {
    $response = $this->actingAs($this->adminUser)->get('/servicios');

    $response->assertStatus(200);
    $response->assertSeeLivewire(ServiciosIndex::class);
});

test('el componente servicios index lista los servicios registrados', function () {
    $servicio = Servicio::create([
        'nombre' => 'Terapia Manual Especializada',
        'descripcion' => 'Terapia para descontracturar columna',
        'precio_base' => 180.00,
        'duracion_minutos' => 45,
        'color' => '#4f46e5',
        'activo' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->assertSee('Terapia Manual Especializada')
        ->assertSee('45 min')
        ->assertSee('Bs. 180.00');
});

test('valida campos requeridos al crear un servicio', function () {
    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('abrirModalCrear')
        ->set('nombre', '')
        ->set('precio_base', '')
        ->set('duracion_minutos', 0)
        ->set('color', 'invalido')
        ->call('guardar')
        ->assertHasErrors(['nombre', 'precio_base', 'duracion_minutos', 'color']);
});

test('puede crear un nuevo servicio de fisioterapia', function () {
    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('abrirModalCrear')
        ->set('nombre', 'Punción Seca Miofascial')
        ->set('descripcion', 'Tratamiento de puntos gatillo miofasciales')
        ->set('duracion_minutos', 30)
        ->set('precio_base', '120.00')
        ->set('color', '#059669')
        ->set('activo', true)
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertSet('mostrarModal', false);

    $this->assertDatabaseHas('servicios', [
        'nombre' => 'Punción Seca Miofascial',
        'duracion_minutos' => 30,
        'color' => '#059669',
        'activo' => true,
    ]);
});

test('puede editar un servicio existente', function () {
    $servicio = Servicio::create([
        'nombre' => 'Electroterapia Tens',
        'descripcion' => 'Sesión de corrientes analgésicas',
        'precio_base' => 90.00,
        'duracion_minutos' => 20,
        'color' => '#d97706',
        'activo' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('abrirModalEditar', $servicio->id)
        ->assertSet('nombre', 'Electroterapia Tens')
        ->set('precio_base', '100.00')
        ->set('duracion_minutos', 25)
        ->call('guardar')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('servicios', [
        'id' => $servicio->id,
        'precio_base' => 100.00,
        'duracion_minutos' => 25,
    ]);
});

test('puede alternar el estado activo e inactivo de un servicio con toggle', function () {
    $servicio = Servicio::create([
        'nombre' => 'Hidroterapia',
        'precio_base' => 150.00,
        'duracion_minutos' => 45,
        'color' => '#0284c7',
        'activo' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('toggleEstado', $servicio->id);

    expect($servicio->fresh()->activo)->toBeFalse();

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('toggleEstado', $servicio->id);

    expect($servicio->fresh()->activo)->toBeTrue();
});

test('puede eliminar suavemente un servicio', function () {
    $servicio = Servicio::create([
        'nombre' => 'Servicio de Prueba Eliminable',
        'precio_base' => 50.00,
        'duracion_minutos' => 15,
        'color' => '#dc2626',
        'activo' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->call('confirmarEliminar', $servicio->id)
        ->assertSet('servicioAEliminarId', $servicio->id)
        ->call('eliminar')
        ->assertSet('mostrarModalEliminar', false);

    $this->assertSoftDeleted('servicios', [
        'id' => $servicio->id,
    ]);
});

test('puede buscar servicios por término de búsqueda', function () {
    Servicio::create([
        'nombre' => 'Rehabilitación Post-Operatoria',
        'precio_base' => 200.00,
        'duracion_minutos' => 60,
        'color' => '#7c3aed',
        'activo' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(ServiciosIndex::class)
        ->set('search', 'Post-Operatoria')
        ->assertSee('Rehabilitación Post-Operatoria')
        ->set('search', 'InexistenteZzz')
        ->assertDontSee('Rehabilitación Post-Operatoria');
});

test('el componente sucursal selector permite al admin cambiar de sucursal', function () {
    Livewire::actingAs($this->adminUser)
        ->test(SucursalSelector::class)
        ->call('cambiarSucursal', $this->sucursal2->id);

    expect(session('sucursal_activa_id'))->toBe($this->sucursal2->id);
});
