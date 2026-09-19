<?php

use App\Livewire\Admin\RolesIndex;
use App\Livewire\Admin\SucursalesIndex;
use App\Livewire\Admin\UsuariosIndex;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->adminRole = Rol::firstOrCreate(
        ['slug' => 'admin'],
        ['nombre' => 'Administrador General', 'descripcion' => 'Acceso completo']
    );

    $this->recepRole = Rol::firstOrCreate(
        ['slug' => 'recepcionista'],
        ['nombre' => 'Recepcionista', 'descripcion' => 'Manejo de citas']
    );

    $this->sucursalCentral = Sucursal::firstOrCreate(
        ['codigo' => 'SUC-01'],
        ['nombre' => 'Sucursal Central', 'activa' => true]
    );

    $this->adminUser = User::factory()->create([
        'name' => 'Super Admin',
        'rol_id' => $this->adminRole->id,
        'sucursal_id' => $this->sucursalCentral->id,
        'activo' => true,
    ]);

    $this->recepUser = User::factory()->create([
        'name' => 'Recepcionista Turno',
        'rol_id' => $this->recepRole->id,
        'sucursal_id' => $this->sucursalCentral->id,
        'activo' => true,
    ]);
});

test('usuarios no autenticados son redirigidos al login en rutas admin', function () {
    $this->get('/admin/sucursales')->assertRedirect('/login');
    $this->get('/admin/roles')->assertRedirect('/login');
    $this->get('/admin/usuarios')->assertRedirect('/login');
});

test('un usuario sin permisos no puede acceder al modulo de administracion', function () {
    $this->actingAs($this->recepUser)->get('/admin/sucursales')->assertStatus(403);
    $this->actingAs($this->recepUser)->get('/admin/roles')->assertStatus(403);
    $this->actingAs($this->recepUser)->get('/admin/usuarios')->assertStatus(403);
});

test('el administrador puede acceder a todas las rutas de administracion', function () {
    $this->actingAs($this->adminUser)->get('/admin/sucursales')->assertStatus(200);
    $this->actingAs($this->adminUser)->get('/admin/roles')->assertStatus(200);
    $this->actingAs($this->adminUser)->get('/admin/usuarios')->assertStatus(200);
});

test('puede crear una nueva sucursal con validaciones', function () {
    Livewire::actingAs($this->adminUser)
        ->test(SucursalesIndex::class)
        ->call('abrirModalCrear')
        ->set('nombre', '')
        ->set('codigo', '')
        ->call('guardar')
        ->assertHasErrors(['nombre', 'codigo'])
        ->set('nombre', 'Sede Miraflores')
        ->set('codigo', 'SUC-MF')
        ->set('ciudad', 'La Paz')
        ->set('telefono', '71234567')
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertSet('mostrarModal', false);

    $this->assertDatabaseHas('sucursales', [
        'nombre' => 'Sede Miraflores',
        'codigo' => 'SUC-MF',
    ]);
});

test('puede editar y cambiar estado de una sucursal', function () {
    $sucursal = Sucursal::create([
        'nombre' => 'Sede Experimental',
        'codigo' => 'SUC-EXP',
        'activa' => true,
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(SucursalesIndex::class)
        ->call('abrirModalEditar', $sucursal->id)
        ->set('nombre', 'Sede Experimental Actualizada')
        ->call('guardar')
        ->assertHasNoErrors();

    expect($sucursal->fresh()->nombre)->toBe('Sede Experimental Actualizada');

    Livewire::actingAs($this->adminUser)
        ->test(SucursalesIndex::class)
        ->call('toggleEstado', $sucursal->id);

    expect($sucursal->fresh()->activa)->toBeFalse();
});

test('puede crear un rol personalizado y no permite eliminar roles del sistema', function () {
    Livewire::actingAs($this->adminUser)
        ->test(RolesIndex::class)
        ->call('abrirModalCrear')
        ->set('nombre', 'Terapeuta Pediátrico')
        ->set('slug', 'terapeuta_pediatrico')
        ->set('descripcion', 'Especialista en niños')
        ->call('guardar')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'slug' => 'terapeuta_pediatrico',
    ]);

    // Intentar eliminar un rol del sistema debe fallar
    Livewire::actingAs($this->adminUser)
        ->test(RolesIndex::class)
        ->call('confirmarEliminar', $this->adminRole->id)
        ->assertSee('No puedes eliminar los roles predeterminados del sistema.');

    // Alternar estado de un rol personalizado
    $nuevoRol = Rol::where('slug', 'terapeuta_pediatrico')->first();
    Livewire::actingAs($this->adminUser)
        ->test(RolesIndex::class)
        ->call('toggleEstado', $nuevoRol->id);

    expect($nuevoRol->fresh()->activo)->toBeFalse();

    // Intentar desactivar rol admin debe estar protegido
    Livewire::actingAs($this->adminUser)
        ->test(RolesIndex::class)
        ->call('toggleEstado', $this->adminRole->id)
        ->assertSee('El rol de Administrador no puede ser desactivado.');
});

test('puede crear un nuevo usuario con sucursal y rol', function () {
    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('abrirModalCrear')
        ->set('name', 'Lic. Andrea Gómez')
        ->set('nombres', 'Andrea')
        ->set('ap_paterno', 'Gómez')
        ->set('email', 'andrea.gomez@fisioclinic.com')
        ->set('password', 'password123')
        ->set('rol_id', $this->recepRole->id)
        ->set('sucursal_id', $this->sucursalCentral->id)
        ->set('activo', true)
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertSet('mostrarModal', false);

    $nuevoUsuario = User::where('email', 'andrea.gomez@fisioclinic.com')->first();
    expect($nuevoUsuario)->not->toBeNull();
    expect(Hash::check('password123', $nuevoUsuario->password))->toBeTrue();
});

test('puede asignar y sincronizar permisos granulares a un usuario', function () {
    $permiso1 = Permiso::firstOrCreate(
        ['clave' => 'caja.cobrar'],
        ['nombre' => 'Realizar Cobros', 'modulo' => 'caja']
    );

    $permiso2 = Permiso::firstOrCreate(
        ['clave' => 'reservas.crear'],
        ['nombre' => 'Crear Reservas', 'modulo' => 'reservas']
    );

    // Asignar ambos permisos a recepUser
    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('abrirModalPermisos', $this->recepUser->id)
        ->set('permisosSeleccionados', [(string) $permiso1->id, (string) $permiso2->id])
        ->call('guardarPermisos');

    expect($this->recepUser->permisos()->pluck('clave')->toArray())
        ->toContain('caja.cobrar', 'reservas.crear');

    expect($this->recepUser->tienePermiso('caja.cobrar'))->toBeTrue();
});

test('un usuario no puede eliminar su propia cuenta desde el listado', function () {
    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('confirmarEliminar', $this->adminUser->id)
        ->assertSee('No puedes eliminar tu propia cuenta.');
});

test('un administrador puede abrir modal y cambiar la contraseña de cualquier usuario', function () {
    $viejoPasswordHash = $this->recepUser->password;

    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('abrirModalPassword', $this->recepUser->id)
        ->assertSet('mostrarModalPassword', true)
        ->assertSet('usuarioPasswordId', $this->recepUser->id)
        ->set('nuevaPassword', 'nuevaClaveSegura2026')
        ->call('cambiarPassword')
        ->assertHasNoErrors()
        ->assertSet('mostrarModalPassword', false);

    $this->recepUser->refresh();
    expect(Hash::check('nuevaClaveSegura2026', $this->recepUser->password))->toBeTrue();
    expect($this->recepUser->password)->not->toBe($viejoPasswordHash);
});

test('valida longitud mínima al cambiar contraseña de usuario', function () {
    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('abrirModalPassword', $this->recepUser->id)
        ->set('nuevaPassword', '123')
        ->call('cambiarPassword')
        ->assertHasErrors(['nuevaPassword']);
});

test('el administrador puede generar contraseña aleatoria para el usuario', function () {
    Livewire::actingAs($this->adminUser)
        ->test(UsuariosIndex::class)
        ->call('abrirModalPassword', $this->recepUser->id)
        ->call('generarPassword')
        ->assertSet('mostrarModalPassword', true);
});
